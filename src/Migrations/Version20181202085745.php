<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202085745 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE password_recovery (id INT AUTO_INCREMENT NOT NULL, user_related_id INT DEFAULT NULL, token VARCHAR(48) NOT NULL, date_create DATETIME NOT NULL, end_date_validity DATETIME NOT NULL, date_used DATETIME NOT NULL, used TINYINT(1) NOT NULL, INDEX IDX_63D40109E60506ED (user_related_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE password_recovery ADD CONSTRAINT FK_63D40109E60506ED FOREIGN KEY (user_related_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE token_validation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE token_validation (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(48) NOT NULL COLLATE utf8mb4_unicode_ci, date_create DATETIME NOT NULL, end_date_validity DATETIME NOT NULL, date_used DATETIME NOT NULL, used TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE password_recovery');
    }
}
