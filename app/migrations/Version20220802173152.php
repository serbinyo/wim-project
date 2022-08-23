<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802173152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breathing_exercise (id VARCHAR(36) NOT NULL, user_id INT NOT NULL, session_number INT NOT NULL, duration VARCHAR(255) NOT NULL, INDEX IDX_C813B9A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lap (id VARCHAR(36) NOT NULL, breathing_exercise_id VARCHAR(36) NOT NULL, number INT NOT NULL, breaths INT NOT NULL, exhale_hold INT NOT NULL, inhale_hold INT NOT NULL, time VARCHAR(255) NOT NULL, INDEX IDX_926FC08CF42A680 (breathing_exercise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE breathing_exercise ADD CONSTRAINT FK_C813B9A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lap ADD CONSTRAINT FK_926FC08CF42A680 FOREIGN KEY (breathing_exercise_id) REFERENCES breathing_exercise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lap DROP FOREIGN KEY FK_926FC08CF42A680');
        $this->addSql('DROP TABLE breathing_exercise');
        $this->addSql('DROP TABLE lap');
        $this->addSql('ALTER TABLE message CHANGE content content LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8_unicode_ci`, CHANGE confirmation_code confirmation_code VARCHAR(255) DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
