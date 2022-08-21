<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816150347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu_element_page');
        $this->addSql('ALTER TABLE menu_element ADD page_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_element ADD CONSTRAINT FK_C99B438719C56181 FOREIGN KEY (page_id_id) REFERENCES page (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C99B438719C56181 ON menu_element (page_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_element_page (menu_element_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_2836667C3EB29EF6 (menu_element_id), INDEX IDX_2836667CC4663E4 (page_id), PRIMARY KEY(menu_element_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_element_page ADD CONSTRAINT FK_2836667C3EB29EF6 FOREIGN KEY (menu_element_id) REFERENCES menu_element (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_element_page ADD CONSTRAINT FK_2836667CC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_element DROP FOREIGN KEY FK_C99B438719C56181');
        $this->addSql('DROP INDEX UNIQ_C99B438719C56181 ON menu_element');
        $this->addSql('ALTER TABLE menu_element DROP page_id_id');
    }
}
