<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241204152151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD commission_id INT DEFAULT NULL, CHANGE sender_id sender_id INT NOT NULL, CHANGE timestamp created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F202D1EB2 ON message (commission_id)');
        $this->addSql('ALTER TABLE utilisateur ADD id_commission INT DEFAULT NULL, ADD roles INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3B9EF818F FOREIGN KEY (id_commission) REFERENCES commission (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3B9EF818F ON utilisateur (id_commission)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F202D1EB2');
        $this->addSql('DROP INDEX IDX_B6BD307F202D1EB2 ON message');
        $this->addSql('ALTER TABLE message DROP commission_id, CHANGE sender_id sender_id INT DEFAULT NULL, CHANGE created_at timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3B9EF818F');
        $this->addSql('DROP INDEX IDX_1D1C63B3B9EF818F ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP id_commission, DROP roles');
    }
}
