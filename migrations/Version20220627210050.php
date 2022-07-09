<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627210050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aliment ADD shop_place_id INT NOT NULL');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972BD61E588F FOREIGN KEY (shop_place_id) REFERENCES shop_place (id)');
        $this->addSql('CREATE INDEX IDX_70FF972BD61E588F ON aliment (shop_place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972BD61E588F');
        $this->addSql('DROP INDEX IDX_70FF972BD61E588F ON aliment');
        $this->addSql('ALTER TABLE aliment DROP shop_place_id');
    }
}
