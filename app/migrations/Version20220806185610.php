<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806185610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lap ADD date_create DATETIME');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, conference_id INT NOT NULL, author VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, text LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', photo_filename VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, state VARCHAR(255) CHARACTER SET utf8 DEFAULT \'submitted\' NOT NULL COLLATE `utf8_unicode_ci`, INDEX IDX_9474526C604B8382 (conference_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, year VARCHAR(4) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, is_international TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_911533C8989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE breathing_exercise CHANGE id id VARCHAR(36) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE duration duration VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE date_create date_create DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE lap DROP date_create, CHANGE id id VARCHAR(36) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE breathing_exercise_id breathing_exercise_id VARCHAR(36) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE time time VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE message CHANGE content content LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE confirmation_code confirmation_code VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
