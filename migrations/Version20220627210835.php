<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627210835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aliment (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, unit_id INT NOT NULL, shop_place_id INT NOT NULL, name VARCHAR(255) NOT NULL, pretty_name VARCHAR(255) NOT NULL, INDEX IDX_70FF972B12469DE2 (category_id), INDEX IDX_70FF972BF8BD700D (unit_id), INDEX IDX_70FF972BD61E588F (shop_place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, aliment_id INT NOT NULL, recipe_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_6BAF7870415B9F11 (aliment_id), INDEX IDX_6BAF787059D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, shoppinglist_id INT DEFAULT NULL, started_at DATE NOT NULL, finished_at DATE NOT NULL, UNIQUE INDEX UNIQ_7D053A934F22EB9A (shoppinglist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, recipe_type_id INT NOT NULL, season_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_DA88B13789A882D3 (recipe_type_id), INDEX IDX_DA88B1374EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, identifier VARCHAR(255) NOT NULL, people_count INT NOT NULL, INDEX IDX_A50B3B45CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift_recipe (shift_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_56502322BB70BC0E (shift_id), INDEX IDX_5650232259D8A214 (recipe_id), PRIMARY KEY(shift_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_list (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972BF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE aliment ADD CONSTRAINT FK_70FF972BD61E588F FOREIGN KEY (shop_place_id) REFERENCES shop_place (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870415B9F11 FOREIGN KEY (aliment_id) REFERENCES aliment (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A934F22EB9A FOREIGN KEY (shoppinglist_id) REFERENCES shopping_list (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13789A882D3 FOREIGN KEY (recipe_type_id) REFERENCES recipe_type (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1374EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE shift ADD CONSTRAINT FK_A50B3B45CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE shift_recipe ADD CONSTRAINT FK_56502322BB70BC0E FOREIGN KEY (shift_id) REFERENCES shift (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shift_recipe ADD CONSTRAINT FK_5650232259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870415B9F11');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972B12469DE2');
        $this->addSql('ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B45CCD7E912');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787059D8A214');
        $this->addSql('ALTER TABLE shift_recipe DROP FOREIGN KEY FK_5650232259D8A214');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13789A882D3');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1374EC001D1');
        $this->addSql('ALTER TABLE shift_recipe DROP FOREIGN KEY FK_56502322BB70BC0E');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972BD61E588F');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A934F22EB9A');
        $this->addSql('ALTER TABLE aliment DROP FOREIGN KEY FK_70FF972BF8BD700D');
        $this->addSql('DROP TABLE aliment');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_type');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE shift');
        $this->addSql('DROP TABLE shift_recipe');
        $this->addSql('DROP TABLE shop_place');
        $this->addSql('DROP TABLE shopping_list');
        $this->addSql('DROP TABLE unit');
    }
}
