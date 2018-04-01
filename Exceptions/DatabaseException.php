<?php

namespace Exceptions;


class DatabaseException extends HttpException
{
    public function configurateDatabaseMessage() {
        switch ($this->code) {
            case '42S22':
                $this->message = 'Une erreur est survenue lors de la requête, veuillez prévenir l\'administrateur';
            default:
                $this->message = 'Une erreur est survenue lors de la requête, veuillez prévenir l\'administrateur';
        }
    }
}