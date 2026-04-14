<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260216220621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_catalog (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(100) NOT NULL, style VARCHAR(100) NOT NULL, image_svg VARCHAR(255) NOT NULL, default_width INT NOT NULL, default_height INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE placed_item (id INT AUTO_INCREMENT NOT NULL, x INT NOT NULL, y INT NOT NULL, rotation INT NOT NULL, current_width INT NOT NULL, current_height INT NOT NULL, plan_id INT NOT NULL, catalog_item_id INT NOT NULL, INDEX IDX_85F5B948E899029B (plan_id), INDEX IDX_85F5B9481DDDAF72 (catalog_item_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width INT NOT NULL, height INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, owner_id INT NOT NULL, INDEX IDX_DD5A5B7D7E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE recommendation (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, plan_id INT NOT NULL, INDEX IDX_433224D2E899029B (plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
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
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7D7E3C61F9');
        $this->addSql('ALTER TABLE recommendation DROP FOREIGN KEY FK_433224D2E899029B');
        $this->addSql('DROP TABLE item_catalog');
        $this->addSql('DROP TABLE placed_item');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE recommendation');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
