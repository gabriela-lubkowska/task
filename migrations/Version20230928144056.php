<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928144056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE currency_order_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE currency_order_item (id INT NOT NULL, order_id INT DEFAULT NULL, currency_id UUID DEFAULT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B10D9A328D9F6D38 ON currency_order_item (order_id)');
        $this->addSql('CREATE INDEX IDX_B10D9A3238248176 ON currency_order_item (currency_id)');
        $this->addSql('COMMENT ON COLUMN currency_order_item.currency_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE currency_order_item ADD CONSTRAINT FK_B10D9A328D9F6D38 FOREIGN KEY (order_id) REFERENCES currency_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE currency_order_item ADD CONSTRAINT FK_B10D9A3238248176 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE currency_order_item_id_seq CASCADE');
        $this->addSql('ALTER TABLE currency_order_item DROP CONSTRAINT FK_B10D9A328D9F6D38');
        $this->addSql('ALTER TABLE currency_order_item DROP CONSTRAINT FK_B10D9A3238248176');
        $this->addSql('DROP TABLE currency_order_item');
    }
}
