<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230418143829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diet_menu (diet_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_871DEE96E1E13ACE (diet_id), INDEX IDX_871DEE96CCD7E912 (menu_id), PRIMARY KEY(diet_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_C53D045FB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, category VARCHAR(100) NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_1F1B251EB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_menu (item_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_B5357E68126F525E (item_id), INDEX IDX_B5357E68CCD7E912 (menu_id), PRIMARY KEY(item_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, reduction NUMERIC(5, 2) NOT NULL, INDEX IDX_7D053A93B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, datetime DATETIME NOT NULL, payment_mode VARCHAR(45) DEFAULT NULL, adult_nb INT NOT NULL, kid_nb INT NOT NULL, service VARCHAR(45) NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(50) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(100) NOT NULL, phone INT NOT NULL, capacity INT NOT NULL, INDEX IDX_EB95123F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_slot (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, day DATE NOT NULL, opening DATETIME NOT NULL, closing DATETIME NOT NULL, INDEX IDX_1B3294AB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, phone INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_restaurant (user_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_4CF2D4D3A76ED395 (user_id), INDEX IDX_4CF2D4D3B1E7706E (restaurant_id), PRIMARY KEY(user_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diet_menu ADD CONSTRAINT FK_871DEE96E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diet_menu ADD CONSTRAINT FK_871DEE96CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE item_menu ADD CONSTRAINT FK_B5357E68126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_menu ADD CONSTRAINT FK_B5357E68CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294AB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE user_restaurant ADD CONSTRAINT FK_4CF2D4D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_restaurant ADD CONSTRAINT FK_4CF2D4D3B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diet_menu DROP FOREIGN KEY FK_871DEE96E1E13ACE');
        $this->addSql('ALTER TABLE diet_menu DROP FOREIGN KEY FK_871DEE96CCD7E912');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB1E7706E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EB1E7706E');
        $this->addSql('ALTER TABLE item_menu DROP FOREIGN KEY FK_B5357E68126F525E');
        $this->addSql('ALTER TABLE item_menu DROP FOREIGN KEY FK_B5357E68CCD7E912');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93B1E7706E');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F12469DE2');
        $this->addSql('ALTER TABLE time_slot DROP FOREIGN KEY FK_1B3294AB1E7706E');
        $this->addSql('ALTER TABLE user_restaurant DROP FOREIGN KEY FK_4CF2D4D3A76ED395');
        $this->addSql('ALTER TABLE user_restaurant DROP FOREIGN KEY FK_4CF2D4D3B1E7706E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE diet');
        $this->addSql('DROP TABLE diet_menu');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_menu');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE time_slot');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_restaurant');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
