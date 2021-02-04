<?php

namespace Drupal\social_auth_telegram\Controller;

use Drupal\Core\Config\Config;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\social_api\Plugin\NetworkManager;
use Drupal\social_auth\Controller\OAuth2ControllerBase;
use Drupal\social_auth\SocialAuthDataHandler;
use Drupal\social_auth\User\UserAuthenticator;
use Drupal\social_auth_telegram\TelegramAuthManager;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use function func_get_args;
use function hash;
use function hash_hmac;
use function implode;
use function sort;
use function strcmp;
use function time;

/**
 * Returns responses for Social Auth Telegram routes.
 */
class TelegramAuthController extends OAuth2ControllerBase {

    /** @var Config */
    protected $config;

    /** @var LoggerChannelInterface */
    protected $logger;

    /**
     * TelegramAuthController constructor.
     *
     * @param \Drupal\Core\Messenger\MessengerInterface $messenger
     *   The messenger service.
     * @param \Drupal\social_api\Plugin\NetworkManager $network_manager
     *   Used to get an instance of social_auth_telegram network plugin.
     * @param \Drupal\social_auth\User\UserAuthenticator $user_authenticator
     *   Manages user login/registration.
     * @param \Drupal\social_auth_telegram\TelegramAuthManager $telegram_manager
     *   Used to manage authentication methods.
     * @param \Symfony\Component\HttpFoundation\RequestStack $request
     *   Used to access GET parameters.
     * @param \Drupal\social_auth\SocialAuthDataHandler $data_handler
     *   The Social Auth data handler.
     * @param \Drupal\Core\Render\RendererInterface $renderer
     *   Used to handle metadata for redirection to authentication URL.
     */
    public function __construct(
        Config $config,
        LoggerChannelInterface $logger,
        MessengerInterface $messenger,
        NetworkManager $network_manager,
        UserAuthenticator $user_authenticator,
        TelegramAuthManager $telegram_manager,
        RequestStack $request,
        SocialAuthDataHandler $data_handler,
        RendererInterface $renderer) {
        $this->config = $config;
        $this->logger = $logger;

        parent::__construct('Social Auth Telegram', 'social_auth_telegram',
            $messenger, $network_manager, $user_authenticator,
            $telegram_manager, $request, $data_handler, $renderer);
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('social_auth_telegram.config'),
            $container->get('logger.channel.social_auth_telegram'),
            $container->get('messenger'),
            $container->get('plugin.network.manager'),
            $container->get('social_auth.user_authenticator'),
            $container->get('social_auth_telegram.manager'),
            $container->get('request_stack'),
            $container->get('social_auth.data_handler'),
            $container->get('renderer')

        );
    }

    public function callback() {
        /** @var $request \Symfony\Component\HttpFoundation\Request */
        $request = \Drupal::request();
        $data_all = $request->query->all();
        $data = array_diff_key($data_all, ['hash' => 1]);
        $token = $this->config()->get('token');
        $hash = $this->getHash($data, $token);

        $success=TRUE;
        
        if (strcmp($hash, $data_all['hash']) !== 0) {
            $success=FALSE;
            $this->logger->error('Data is NOT from Telegram');
        }
        if ((time() - $data_all['hash']) > 86400) {
            $success=FALSE;
            $this->logger->error('Data is outdated');
        }
        
        
        if ($success) {

            $name = 'TODO';

            // If user information could be retrieved.
            return $this->userAuthenticator->authenticateUser($data['username'],
                \Drupal::config('system.site')->get('mail'),
                $data['id'],
                $this->providerManager->getAccessToken(),
                $profile->toArray()['avatar_url'],
                $data);
        }

        return $this->redirect('user.login');
    }

    private function getHash($auth_data, $token) {
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = "{$key}={$value}";
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);

        $secret_key = hash('sha256', $token, TRUE);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        return $hash;
    }

    function checkTelegramAuthorization($auth_data, $token) {
        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = "{$key}={$value}";
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);

        $secret_key = hash('sha256', $token, TRUE);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);

        return $auth_data;
    }
}
