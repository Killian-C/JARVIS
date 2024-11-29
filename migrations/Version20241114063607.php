<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114063607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list_item (id INT AUTO_INCREMENT NOT NULL, shopping_list_id INT NOT NULL, content VARCHAR(255) NOT NULL, quantity DOUBLE PRECISION DEFAULT NULL, checked TINYINT(1) DEFAULT NULL, INDEX IDX_5AD5FAF723245BF9 (shopping_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_item ADD CONSTRAINT FK_5AD5FAF723245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id)');
        $this->addSql('ALTER TABLE shopping_list DROP content');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_item DROP FOREIGN KEY FK_5AD5FAF723245BF9');
        $this->addSql('DROP TABLE list_item');
        $this->addSql('ALTER TABLE shopping_list ADD content LONGTEXT NOT NULL');
    }
}
