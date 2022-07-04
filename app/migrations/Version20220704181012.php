<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704181012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breathing (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, session INT NOT NULL, laps INT NOT NULL, duration DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FDA14F42A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE round (id INT AUTO_INCREMENT NOT NULL, breath_id INT NOT NULL, lap INT NOT NULL, breaths INT NOT NULL, hold_time TIME NOT NULL, round_time TIME NOT NULL, INDEX IDX_C5EEEA34B0F111D (breath_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE breathing ADD CONSTRAINT FK_FDA14F42A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA34B0F111D FOREIGN KEY (breath_id) REFERENCES breathing (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA34B0F111D');
        $this->addSql('DROP TABLE breathing');
        $this->addSql('DROP TABLE round');
        $this->addSql('ALTER TABLE comment CHANGE author author VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE text text LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE photo_filename photo_filename VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE state state VARCHAR(255) DEFAULT \'submitted\' NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE conference CHANGE city city VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE year year VARCHAR(4) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE message CHANGE content content LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE confirmation_code confirmation_code VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
