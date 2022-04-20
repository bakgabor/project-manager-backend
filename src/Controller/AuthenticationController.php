<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Services\Authentication\Authentication;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

use App\Entity\User;
use App\Security\AuthenticationSuccessHandler;
use HWI\Bundle\OAuthBundle\Controller\ConnectController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class AuthenticationController extends AbstractController
{

    private $eventDispatcher;
    private $tokenStorage;

    public function __construct(EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/api/authentication/signup", methods={"POST"}, name="api_signup")
     */
    public function signupActions(Request $request, Authentication $auth)
    {
        return $auth->signupActions($request);
    }

    /**
     * @Route("/api/authentication/login", methods={"POST"}, name="api_login")
     */
    public function loginAction(Request $request, Authentication $auth): Response
    {
        return $auth->loginActions($request);
    }

    /**
     * @Route("/api/authentication/logout", methods={"POST"}, name="api_logout")
     */
    public function logoutAction(): Response
    {
        return $this->json('Ha ezt látod akkor valami hiba van!', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Route("/api/authentication/user", methods={"GET"}, name="api_user")
     */
    public function userAction(AuthenticationSuccessHandler $auth): Response
    {
        $user = $this->getUser();
        $user = $auth->userObjectReducer($user);
        return new JsonResponse(['user' => $user]);
    }


    /**
     * @Route("/api/authentication/update", methods={"POST"}, name="update-user")
     */
    public function updateUserData(Request $request, Authentication $auth): Response
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent());

        $auth->updateOrCreateUser($data, $user);

        return new JsonResponse(['status' => 'ok']);
    }


    /**
     * @Route("/api/authentication/create", methods={"POST"}, name="create-user")
     */
    public function createUser(Request $request, Authentication $auth): Response
    {

        $data = json_decode($request->getContent());

        $auth->updateOrCreateUser($data);

        return new JsonResponse(['status' => 'ok']);
    }

}