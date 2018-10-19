<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Infrastructure\EntityManager;

use App\Exception\ORMException;

trait EntityManagerORMExceptionTrait
{
    /**7
     * @param callable $ORMAction
     * @param mixed ...$parameter
     * @throws ORMException
     */
    public function standardizeORMException(callable $ORMAction, ...$parameter)
    {
        try {
            call_user_func_array($ORMAction, $parameter);
        } catch (\Exception $e) {
            throw new ORMException("Error occurred : " . $e -> getMessage(), 0, $e);
        }
    }
}
