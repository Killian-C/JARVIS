<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213065047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_item ADD shop_place_id INT NOT NULL');
        $this->addSql('ALTER TABLE list_item ADD CONSTRAINT FK_5AD5FAF7D61E588F FOREIGN KEY (shop_place_id) REFERENCES shop_place (id)');
        $this->addSql('CREATE INDEX IDX_5AD5FAF7D61E588F ON list_item (shop_place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_item DROP FOREIGN KEY FK_5AD5FAF7D61E588F');
        $this->addSql('DROP INDEX IDX_5AD5FAF7D61E588F ON list_item');
        $this->addSql('ALTER TABLE list_item DROP shop_place_id');
    }
}
