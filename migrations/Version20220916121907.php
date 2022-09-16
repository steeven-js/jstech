<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916121907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE header CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE content content LONGTEXT DEFAULT NULL, CHANGE btn_title btn_title VARCHAR(255) DEFAULT NULL, CHANGE btn_url btn_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE header CHANGE title title VARCHAR(255) NOT NULL, CHANGE content content LONGTEXT NOT NULL, CHANGE btn_title btn_title VARCHAR(255) NOT NULL, CHANGE btn_url btn_url VARCHAR(255) NOT NULL');
    }
}
