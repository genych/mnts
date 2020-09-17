<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917112734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          client_id INTEGER DEFAULT NULL,
          currency CHAR(3) NOT NULL,
          balance INTEGER NOT NULL
        )');
        $this->addSql('CREATE INDEX IDX_7D3656A419EB6921 ON account (client_id)');
        $this->addSql('CREATE TABLE client (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          first_name VARCHAR(255) NOT NULL,
          last_name VARCHAR(255) DEFAULT NULL
        )');
        $this->addSql('CREATE TABLE "transaction" (
          id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
          from_account_id INTEGER NOT NULL,
          to_account_id INTEGER NOT NULL,
          amount INTEGER NOT NULL,
          currency CHAR(3) NOT NULL,
          dt DATETIME NOT NULL
        )');
        $this->addSql('CREATE INDEX IDX_723705D1B0CF99BD ON "transaction" (from_account_id)');
        $this->addSql('CREATE INDEX IDX_723705D1BC58BDC7 ON "transaction" (to_account_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE "transaction"');
    }
}
