<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312085350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE states (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quotes ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE quotes ADD CONSTRAINT FK_A1B588C55D83CC1 FOREIGN KEY (state_id) REFERENCES states (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A1B588C55D83CC1 ON quotes (state_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quotes DROP FOREIGN KEY FK_A1B588C55D83CC1');
        $this->addSql('DROP TABLE states');
        $this->addSql('DROP INDEX UNIQ_A1B588C55D83CC1 ON quotes');
        $this->addSql('ALTER TABLE quotes DROP state_id');
    }
}
