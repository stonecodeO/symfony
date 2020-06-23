<?php
/**
 * Created by PhpStorm.
 * User: stonecode
 * Date: 04/02/2020
 * Time: 23:12
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $content = "Vous n'avez pas le droit d'acceder à cette page...contacter l'\administrateur";
        return new Response($content, 403);

    }
}