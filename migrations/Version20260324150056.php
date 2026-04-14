<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260324150056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE placed_item CHANGE catalog_item_id catalog_item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE placed_item ADD CONSTRAINT FK_85F5B948E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE placed_item ADD CONSTRAINT FK_85F5B9481DDDAF72 FOREIGN KEY (catalog_item_id) REFERENCES item_catalog (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE recommendation ADD CONSTRAINT FK_433224D2E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE placed_item DROP FOREIGN KEY FK_85F5B948E899029B');
        $this->addSql('ALTER TABLE placed_item DROP FOREIGN KEY FK_85F5B9481DDDAF72');
        $this->addSql('ALTER TABLE placed_item CHANGE catalog_item_id catalog_item_id INT NOT NULL');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D7E3C61F9');
        $this->addSql('ALTER TABLE recommendation DROP FOREIGN KEY FK_433224D2E899029B');
    }
}
