<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917122505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7D3656A419EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__account AS SELECT id, client_id, currency, balance FROM account');
        $this->addSql('DROP TABLE account');
        $this->addSql('CREATE TABLE account (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          client_id INTEGER DEFAULT NULL,
          balance INTEGER NOT NULL,
          currency VARCHAR(3) NOT NULL,
          CONSTRAINT FK_7D3656A419EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO account (id, client_id, currency, balance)
        SELECT
          id,
          client_id,
          currency,
          balance
        FROM
          __temp__account');
        $this->addSql('DROP TABLE __temp__account');
        $this->addSql('CREATE INDEX IDX_7D3656A419EB6921 ON account (client_id)');
        $this->addSql('ALTER TABLE client ADD COLUMN country CHAR(3) NOT NULL');
        $this->addSql('DROP INDEX IDX_723705D1BC58BDC7');
        $this->addSql('DROP INDEX IDX_723705D1B0CF99BD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__transaction AS
        SELECT
          id,
          from_account_id,
          to_account_id,
          amount,
          currency,
          dt
        FROM
          "transaction"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('CREATE TABLE "transaction" (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          from_account_id INTEGER NOT NULL,
          to_account_id INTEGER NOT NULL,
          amount INTEGER NOT NULL,
          dt DATETIME NOT NULL,
          currency VARCHAR(3) NOT NULL,
          CONSTRAINT FK_723705D1B0CF99BD FOREIGN KEY (from_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE,
          CONSTRAINT FK_723705D1BC58BDC7 FOREIGN KEY (to_account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        )');
        $this->addSql('INSERT INTO "transaction" (
          id, from_account_id, to_account_id,
          amount, currency, dt
        )
        SELECT
          id,
          from_account_id,
          to_account_id,
          amount,
          currency,
          dt
        FROM
          __temp__transaction');
        $this->addSql('DROP TABLE __temp__transaction');
        $this->addSql('CREATE INDEX IDX_723705D1BC58BDC7 ON "transaction" (to_account_id)');
        $this->addSql('CREATE INDEX IDX_723705D1B0CF99BD ON "transaction" (from_account_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7D3656A419EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__account AS SELECT id, client_id, currency, balance FROM account');
        $this->addSql('DROP TABLE account');
        $this->addSql('CREATE TABLE account (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          client_id INTEGER DEFAULT NULL,
          balance INTEGER NOT NULL,
          currency CHAR(3) NOT NULL COLLATE BINARY
        )');
        $this->addSql('INSERT INTO account (id, client_id, currency, balance)
        SELECT
          id,
          client_id,
          currency,
          balance
        FROM
          __temp__account');
        $this->addSql('DROP TABLE __temp__account');
        $this->addSql('CREATE INDEX IDX_7D3656A419EB6921 ON account (client_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, first_name, last_name FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          first_name VARCHAR(255) NOT NULL,
          last_name VARCHAR(255) DEFAULT NULL
        )');
        $this->addSql('INSERT INTO client (id, first_name, last_name)
        SELECT
          id,
          first_name,
          last_name
        FROM
          __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('DROP INDEX IDX_723705D1B0CF99BD');
        $this->addSql('DROP INDEX IDX_723705D1BC58BDC7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__transaction AS
        SELECT
          id,
          from_account_id,
          to_account_id,
          amount,
          currency,
          dt
        FROM
          "transaction"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('CREATE TABLE "transaction" (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          from_account_id INTEGER NOT NULL,
          to_account_id INTEGER NOT NULL,
          amount INTEGER NOT NULL,
          dt DATETIME NOT NULL,
          currency CHAR(3) NOT NULL COLLATE BINARY
        )');
        $this->addSql('INSERT INTO "transaction" (
          id, from_account_id, to_account_id,
          amount, currency, dt
        )
        SELECT
          id,
          from_account_id,
          to_account_id,
          amount,
          currency,
          dt
        FROM
          __temp__transaction');
        $this->addSql('DROP TABLE __temp__transaction');
        $this->addSql('CREATE INDEX IDX_723705D1B0CF99BD ON "transaction" (from_account_id)');
        $this->addSql('CREATE INDEX IDX_723705D1BC58BDC7 ON "transaction" (to_account_id)');
    }
}
