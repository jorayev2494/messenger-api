<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116225828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_auth_devices (uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, author_uuid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EE29CC68C74F2195 (refresh_token), INDEX IDX_EE29CC683590D879 (author_uuid), PRIMARY KEY(uuid))');
        $this->addSql('ALTER TABLE client_auth_devices ADD CONSTRAINT FK_EE29CC683590D879 FOREIGN KEY (author_uuid) REFERENCES client_auth_accounts (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_auth_devices DROP FOREIGN KEY FK_EE29CC683590D879');
        $this->addSql('DROP TABLE client_auth_devices');
    }
}
