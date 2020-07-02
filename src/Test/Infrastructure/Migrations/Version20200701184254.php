<?php

declare(strict_types=1);

namespace Test\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200701184254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE balance (user_id UUID NOT NULL, value INT NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('COMMENT ON COLUMN balance.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE transaction (transaction_id UUID NOT NULL, user_id UUID NOT NULL, amount_value INT NOT NULL, type_value VARCHAR(255) NOT NULL, PRIMARY KEY(transaction_id))');
        $this->addSql('COMMENT ON COLUMN transaction.transaction_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transaction.user_id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE transaction');
    }
}
