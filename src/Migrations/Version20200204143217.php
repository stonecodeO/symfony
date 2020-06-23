<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204143217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category_product');
        $this->addSql('ALTER TABLE product ADD COLUMN category_id INTEGER');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, password, role FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, role VARCHAR(255) DEFAULT \'ROLE_USER\')');
        $this->addSql('INSERT INTO user (id, username, email, password, role) SELECT id, username, email, password, role FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category_product (category_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(category_id, product_id))');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, price, description, image, promo, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, promo BOOLEAN NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO product (id, name, price, description, image, promo, updated_at) SELECT id, name, price, description, image, promo, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, password, role FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) DEFAULT \'ROLE_USER\' NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO user (id, username, email, password, role) SELECT id, username, email, password, role FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
