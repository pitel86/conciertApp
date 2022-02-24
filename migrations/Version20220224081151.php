<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224081151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE festival_user DROP FOREIGN KEY FK_576D3FDEA76ED395');
        $this->addSql('ALTER TABLE user_concert DROP FOREIGN KEY FK_8D711CD8A76ED395');
        $this->addSql('DROP TABLE festival_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_concert');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE festival_user (festival_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_576D3FDE8AEBAF57 (festival_id), INDEX IDX_576D3FDEA76ED395 (user_id), PRIMARY KEY(festival_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_concert (user_id INT NOT NULL, concert_id INT NOT NULL, INDEX IDX_8D711CD883C97B2E (concert_id), INDEX IDX_8D711CD8A76ED395 (user_id), PRIMARY KEY(user_id, concert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT FK_576D3FDE8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT FK_576D3FDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert ADD CONSTRAINT FK_8D711CD883C97B2E FOREIGN KEY (concert_id) REFERENCES concert (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert ADD CONSTRAINT FK_8D711CD8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
