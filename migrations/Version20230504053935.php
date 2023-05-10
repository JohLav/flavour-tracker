<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504053935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, department VARCHAR(3) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, simple_name VARCHAR(45) DEFAULT NULL, real_name VARCHAR(45) DEFAULT NULL, soundex_name VARCHAR(20) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, city VARCHAR(3) NOT NULL, common_code VARCHAR(5) NOT NULL, district SMALLINT DEFAULT NULL, canton VARCHAR(4) DEFAULT NULL, longitude_deg DOUBLE PRECISION DEFAULT NULL, latitude_deg DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurant ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_EB95123F8BAC62AF ON restaurant (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F8BAC62AF');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP INDEX IDX_EB95123F8BAC62AF ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP city_id');
    }
}
