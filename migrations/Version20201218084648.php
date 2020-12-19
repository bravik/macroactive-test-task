<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218084648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat__authors (id CHAR(36) NOT NULL --(DC2Type:chat__id)
        , email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE661C1CE7927C74 ON chat__authors (email)');
        $this->addSql('CREATE TABLE chat__messages (id CHAR(36) NOT NULL --(DC2Type:chat__id)
        , author_id CHAR(36) DEFAULT NULL --(DC2Type:chat__id)
        , content VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D32F498DF675F31B ON chat__messages (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE chat__authors');
        $this->addSql('DROP TABLE chat__messages');
    }
}
