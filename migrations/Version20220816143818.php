<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816143818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_element (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(32) NOT NULL, href VARCHAR(512) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_element_page (menu_element_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_2836667C3EB29EF6 (menu_element_id), INDEX IDX_2836667CC4663E4 (page_id), PRIMARY KEY(menu_element_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_element_page ADD CONSTRAINT FK_2836667C3EB29EF6 FOREIGN KEY (menu_element_id) REFERENCES menu_element (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_element_page ADD CONSTRAINT FK_2836667CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_element_page DROP FOREIGN KEY FK_2836667C3EB29EF6');
        $this->addSql('DROP TABLE menu_element');
        $this->addSql('DROP TABLE menu_element_page');
    }
}
