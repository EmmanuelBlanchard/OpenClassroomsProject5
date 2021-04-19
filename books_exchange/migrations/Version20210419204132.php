<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419204132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD userexchange_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331AC83E734 FOREIGN KEY (userexchange_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331AC83E734 ON book (userexchange_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331AC83E734');
        $this->addSql('DROP INDEX IDX_CBE5A331AC83E734 ON book');
        $this->addSql('ALTER TABLE book DROP userexchange_id');
    }
}
