<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240629144849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tax_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, code VARCHAR(3) NOT NULL, type SMALLINT NOT NULL, discount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(50) NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tax (id INT NOT NULL, country VARCHAR(50) NOT NULL, code VARCHAR(2) NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tax_id_seq CASCADE');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE tax');
    }
}
