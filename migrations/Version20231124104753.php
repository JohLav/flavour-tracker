<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124104753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_item (menu_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_D754D550CCD7E912 (menu_id), INDEX IDX_D754D550126F525E (item_id), PRIMARY KEY(menu_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_diet (menu_id INT NOT NULL, diet_id INT NOT NULL, INDEX IDX_55AB956ECCD7E912 (menu_id), INDEX IDX_55AB956EE1E13ACE (diet_id), PRIMARY KEY(menu_id, diet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_item ADD CONSTRAINT FK_D754D550126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_diet ADD CONSTRAINT FK_55AB956ECCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_diet ADD CONSTRAINT FK_55AB956EE1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_menu DROP FOREIGN KEY FK_B5357E68126F525E');
        $this->addSql('ALTER TABLE item_menu DROP FOREIGN KEY FK_B5357E68CCD7E912');
        $this->addSql('ALTER TABLE diet_menu DROP FOREIGN KEY FK_871DEE96CCD7E912');
        $this->addSql('ALTER TABLE diet_menu DROP FOREIGN KEY FK_871DEE96E1E13ACE');
        $this->addSql('DROP TABLE item_menu');
        $this->addSql('DROP TABLE diet_menu');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE available_at available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_menu (item_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_B5357E68126F525E (item_id), INDEX IDX_B5357E68CCD7E912 (menu_id), PRIMARY KEY(item_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE diet_menu (diet_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_871DEE96E1E13ACE (diet_id), INDEX IDX_871DEE96CCD7E912 (menu_id), PRIMARY KEY(diet_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE item_menu ADD CONSTRAINT FK_B5357E68126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_menu ADD CONSTRAINT FK_B5357E68CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diet_menu ADD CONSTRAINT FK_871DEE96CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diet_menu ADD CONSTRAINT FK_871DEE96E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_item DROP FOREIGN KEY FK_D754D550CCD7E912');
        $this->addSql('ALTER TABLE menu_item DROP FOREIGN KEY FK_D754D550126F525E');
        $this->addSql('ALTER TABLE menu_diet DROP FOREIGN KEY FK_55AB956ECCD7E912');
        $this->addSql('ALTER TABLE menu_diet DROP FOREIGN KEY FK_55AB956EE1E13ACE');
        $this->addSql('DROP TABLE menu_item');
        $this->addSql('DROP TABLE menu_diet');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }
}
