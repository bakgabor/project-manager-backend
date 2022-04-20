<?php


namespace App\Services\Authentication;


use App\Entity\User;
use App\Security\AuthenticationSuccessHandler;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class Authentication
{

    private $eventDispatcher;
    private $tokenStorage;
    private $authenticationSuccessHandler;
    private $encoder;
    protected $container;
    private $security;
    private $entityManager;
    private $passwordEncoder;

    public function __construct(
        Container $container,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage,
        AuthenticationSuccessHandler $authenticationSuccessHandler,
        JWTEncoderInterface $encoder,
        Security $security,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordEncoder
    ) {
        $this->authenticationSuccessHandler = $authenticationSuccessHandler;
        $this->encoder = $encoder;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function signupActions(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $userName = $data['userName'];

        $emailExist = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $userName]);


        if($emailExist){
            $response = new JsonResponse();
            $response->setData("user name " . $userName . " existiert bereits");
            return $response;
        }

        $user = new User();

        $user->setEmail($userName);
        $user->setPassword($this->passwordEncoder->hashPassword(
            $user,
            $data['password']
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->generateToken($user);
    }

    public function loginActions(Request $request)
    {

        $requestData = json_decode($request->getContent(), true);

        $password = $requestData['loginForm']['password'];
        $email = $requestData['loginForm']['userName'];

        if (!$email || !$password){
            return new JsonResponse(['error' => 'MISSING_CREDENTIALS'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);


        if(!$user) {
            return new JsonResponse(['error' => 'INVALID_CREDENTIALS'], Response::HTTP_FORBIDDEN);
        }

        if(!$this->container->get('security.password_encoder')->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'INVALID_CREDENTIALS'], Response::HTTP_FORBIDDEN);
        }

        return $this->generateToken($user);
    }


    protected function generateToken($user, $statusCode = 200)
    {
        $token = $this->encoder->encode(['username' => $user->getUsername()]);

        $JwtResponse = $this->authenticationSuccessHandler->handleAuthenticationSuccess($user, $token);

        return $JwtResponse;
    }

    public function updateOrCreateUser($data, $user = null)
    {
        $user = $this->createEntity($data, $user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function createEntity($data, $user = null)
    {
        if (!$user) {
            $user = new User();
        }

        $user->setEmail($data['email']);
//        $user->setRoles();

        if (!empty ($data['password'])) {
            $user->setPassword($this->passwordEncoder->hashPassword(
                $user,
                $data['password']
            ));
        }
        return $user;
    }

}