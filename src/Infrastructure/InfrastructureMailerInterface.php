<?php
/**
 * Crée par Jérémy Gaultier <contact@webmezenc.com>
 * Tous droits réservés
 */

namespace App\Infrastructure;

use App\Entity\ValueObject\Mail;

interface InfrastructureMailerInterface
{
    public function addTo(string $email);
    public function setSender(string $email, string $name = null);
    public function setSubject(string $subject);
    public function setContent(string $content);
    public function setReplyTo(string $email);
    public function send(): bool;
    public function getEmailTemplate(string $templateName, Mail $mail): string;
    public function getMailValueObject(): Mail;
}