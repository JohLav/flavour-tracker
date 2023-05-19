<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518112808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation CHANGE datetime date_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE time_slot CHANGE opening opening TIME NOT NULL, CHANGE closing closing TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_slot CHANGE opening opening TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', CHANGE closing closing TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\'');
        $this->addSql('ALTER TABLE reservation CHANGE date_time datetime DATETIME NOT NULL');
    }
}
