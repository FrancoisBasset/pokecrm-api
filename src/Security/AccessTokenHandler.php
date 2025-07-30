<?php
namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface {
    public function __construct(private UserRepository $userRepository) {}

    public function getUserBadgeFrom(string $accessToken): UserBadge {
        // e.g. query the "access token" database to search for this token
        $user = $this->userRepository->findOneByAccesstoken($accessToken);
        if (!isset($user)) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        // and return a UserBadge object containing the user identifier from the found token
        // (this is the same identifier used in Security configuration; it can be an email,
        // a UUID, a username, a database ID, etc.)
        return new UserBadge($user->getUsername());
    }
}