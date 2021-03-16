<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316145058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE miniatures_groups DROP INDEX UNIQ_E8B1EA56BCFC6D57, ADD INDEX IDX_E8B1EA56BCFC6D57 (quality_id)');
        $this->addSql('ALTER TABLE miniatures_groups DROP INDEX UNIQ_E8B1EA56F73142C2, ADD INDEX IDX_E8B1EA56F73142C2 (scale_id)');
        $this->addSql('ALTER TABLE quotes DROP INDEX UNIQ_A1B588C5A76ED395, ADD INDEX IDX_A1B588C5A76ED395 (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE miniatures_groups DROP INDEX IDX_E8B1EA56F73142C2, ADD UNIQUE INDEX UNIQ_E8B1EA56F73142C2 (scale_id)');
        $this->addSql('ALTER TABLE miniatures_groups DROP INDEX IDX_E8B1EA56BCFC6D57, ADD UNIQUE INDEX UNIQ_E8B1EA56BCFC6D57 (quality_id)');
        $this->addSql('ALTER TABLE quotes DROP INDEX IDX_A1B588C5A76ED395, ADD UNIQUE INDEX UNIQ_A1B588C5A76ED395 (user_id)');
    }
}
