<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213104230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE miniatures_groups ADD quote_id INT NOT NULL, ADD scale_id INT NOT NULL, ADD quality_id INT NOT NULL, ADD quantity INT NOT NULL, ADD want_built TINYINT(1) NOT NULL, ADD brand VARCHAR(32) NOT NULL, ADD comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE miniatures_groups ADD CONSTRAINT FK_E8B1EA56DB805178 FOREIGN KEY (quote_id) REFERENCES quotes (id)');
        $this->addSql('ALTER TABLE miniatures_groups ADD CONSTRAINT FK_E8B1EA56F73142C2 FOREIGN KEY (scale_id) REFERENCES scales (id)');
        $this->addSql('ALTER TABLE miniatures_groups ADD CONSTRAINT FK_E8B1EA56BCFC6D57 FOREIGN KEY (quality_id) REFERENCES qualities (id)');
        $this->addSql('CREATE INDEX IDX_E8B1EA56DB805178 ON miniatures_groups (quote_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8B1EA56F73142C2 ON miniatures_groups (scale_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8B1EA56BCFC6D57 ON miniatures_groups (quality_id)');
        $this->addSql('ALTER TABLE qualities ADD name VARCHAR(32) NOT NULL, ADD price_multiplier DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE quotes ADD state_id INT NOT NULL, ADD name VARCHAR(64) NOT NULL, ADD created_at DATETIME NOT NULL, ADD color_scheme VARCHAR(512) NOT NULL');
        $this->addSql('ALTER TABLE quotes ADD CONSTRAINT FK_A1B588C55D83CC1 FOREIGN KEY (state_id) REFERENCES states (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A1B588C55D83CC1 ON quotes (state_id)');
        $this->addSql('ALTER TABLE scales ADD name VARCHAR(32) NOT NULL, ADD paint_price INT NOT NULL, ADD build_price INT NOT NULL');
        $this->addSql('ALTER TABLE states ADD name VARCHAR(32) NOT NULL');
        $this->addSql('ALTER TABLE users ADD name VARCHAR(32) NOT NULL, ADD mail VARCHAR(32) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE miniatures_groups DROP FOREIGN KEY FK_E8B1EA56DB805178');
        $this->addSql('ALTER TABLE miniatures_groups DROP FOREIGN KEY FK_E8B1EA56F73142C2');
        $this->addSql('ALTER TABLE miniatures_groups DROP FOREIGN KEY FK_E8B1EA56BCFC6D57');
        $this->addSql('DROP INDEX IDX_E8B1EA56DB805178 ON miniatures_groups');
        $this->addSql('DROP INDEX UNIQ_E8B1EA56F73142C2 ON miniatures_groups');
        $this->addSql('DROP INDEX UNIQ_E8B1EA56BCFC6D57 ON miniatures_groups');
        $this->addSql('ALTER TABLE miniatures_groups DROP quote_id, DROP scale_id, DROP quality_id, DROP quantity, DROP want_built, DROP brand, DROP comment');
        $this->addSql('ALTER TABLE qualities DROP name, DROP price_multiplier');
        $this->addSql('ALTER TABLE quotes DROP FOREIGN KEY FK_A1B588C55D83CC1');
        $this->addSql('DROP INDEX UNIQ_A1B588C55D83CC1 ON quotes');
        $this->addSql('ALTER TABLE quotes DROP state_id, DROP name, DROP created_at, DROP color_scheme');
        $this->addSql('ALTER TABLE scales DROP name, DROP paint_price, DROP build_price');
        $this->addSql('ALTER TABLE states DROP name');
        $this->addSql('ALTER TABLE users DROP name, DROP mail');
    }
}
