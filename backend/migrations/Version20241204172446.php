<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241204172446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_commission (commission_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_2EDDC34E202D1EB2 (commission_id), INDEX IDX_2EDDC34EFB88E14F (utilisateur_id), PRIMARY KEY(commission_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_commission ADD CONSTRAINT FK_2EDDC34E202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_commission ADD CONSTRAINT FK_2EDDC34EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link_comm_user DROP FOREIGN KEY FK_20C6AB42B9EF818F');
        $this->addSql('ALTER TABLE link_comm_user DROP FOREIGN KEY FK_20C6AB4250EAE44');
        $this->addSql('DROP INDEX IDX_20C6AB42B9EF818F ON link_comm_user');
        $this->addSql('DROP INDEX IDX_20C6AB4250EAE44 ON link_comm_user');
        $this->addSql('ALTER TABLE link_comm_user ADD utilisateur_id INT NOT NULL, ADD commission_id INT NOT NULL, DROP id_utilisateur, DROP id_commission');
        $this->addSql('ALTER TABLE link_comm_user ADD CONSTRAINT FK_20C6AB42FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE link_comm_user ADD CONSTRAINT FK_20C6AB42202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id)');
        $this->addSql('CREATE INDEX IDX_20C6AB42FB88E14F ON link_comm_user (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_20C6AB42202D1EB2 ON link_comm_user (commission_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_commission DROP FOREIGN KEY FK_2EDDC34E202D1EB2');
        $this->addSql('ALTER TABLE utilisateur_commission DROP FOREIGN KEY FK_2EDDC34EFB88E14F');
        $this->addSql('DROP TABLE utilisateur_commission');
        $this->addSql('ALTER TABLE link_comm_user DROP FOREIGN KEY FK_20C6AB42FB88E14F');
        $this->addSql('ALTER TABLE link_comm_user DROP FOREIGN KEY FK_20C6AB42202D1EB2');
        $this->addSql('DROP INDEX IDX_20C6AB42FB88E14F ON link_comm_user');
        $this->addSql('DROP INDEX IDX_20C6AB42202D1EB2 ON link_comm_user');
        $this->addSql('ALTER TABLE link_comm_user ADD id_utilisateur INT DEFAULT NULL, ADD id_commission INT DEFAULT NULL, DROP utilisateur_id, DROP commission_id');
        $this->addSql('ALTER TABLE link_comm_user ADD CONSTRAINT FK_20C6AB42B9EF818F FOREIGN KEY (id_commission) REFERENCES commission (id)');
        $this->addSql('ALTER TABLE link_comm_user ADD CONSTRAINT FK_20C6AB4250EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_20C6AB42B9EF818F ON link_comm_user (id_commission)');
        $this->addSql('CREATE INDEX IDX_20C6AB4250EAE44 ON link_comm_user (id_utilisateur)');
    }
}
