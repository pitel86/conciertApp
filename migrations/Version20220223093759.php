<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223093759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_concert (category_id INT NOT NULL, concert_id INT NOT NULL, INDEX IDX_12A442AC12469DE2 (category_id), INDEX IDX_12A442AC83C97B2E (concert_id), PRIMARY KEY(category_id, concert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_festival (category_id INT NOT NULL, festival_id INT NOT NULL, INDEX IDX_B20673F212469DE2 (category_id), INDEX IDX_B20673F28AEBAF57 (festival_id), PRIMARY KEY(category_id, festival_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert (id INT AUTO_INCREMENT NOT NULL, group_name VARCHAR(255) NOT NULL, date DATE NOT NULL, price VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, place VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE festival (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date_ini DATE NOT NULL, date_fin DATE NOT NULL, price VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, place VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE festival_user (festival_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_576D3FDE8AEBAF57 (festival_id), INDEX IDX_576D3FDEA76ED395 (user_id), PRIMARY KEY(festival_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_concert (user_id INT NOT NULL, concert_id INT NOT NULL, INDEX IDX_8D711CD8A76ED395 (user_id), INDEX IDX_8D711CD883C97B2E (concert_id), PRIMARY KEY(user_id, concert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_concert ADD CONSTRAINT FK_12A442AC12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_concert ADD CONSTRAINT FK_12A442AC83C97B2E FOREIGN KEY (concert_id) REFERENCES concert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_festival ADD CONSTRAINT FK_B20673F212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_festival ADD CONSTRAINT FK_B20673F28AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT FK_576D3FDE8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE festival_user ADD CONSTRAINT FK_576D3FDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert ADD CONSTRAINT FK_8D711CD8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_concert ADD CONSTRAINT FK_8D711CD883C97B2E FOREIGN KEY (concert_id) REFERENCES concert (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_concert DROP FOREIGN KEY FK_12A442AC12469DE2');
        $this->addSql('ALTER TABLE category_festival DROP FOREIGN KEY FK_B20673F212469DE2');
        $this->addSql('ALTER TABLE category_concert DROP FOREIGN KEY FK_12A442AC83C97B2E');
        $this->addSql('ALTER TABLE user_concert DROP FOREIGN KEY FK_8D711CD883C97B2E');
        $this->addSql('ALTER TABLE category_festival DROP FOREIGN KEY FK_B20673F28AEBAF57');
        $this->addSql('ALTER TABLE festival_user DROP FOREIGN KEY FK_576D3FDE8AEBAF57');
        $this->addSql('ALTER TABLE festival_user DROP FOREIGN KEY FK_576D3FDEA76ED395');
        $this->addSql('ALTER TABLE user_concert DROP FOREIGN KEY FK_8D711CD8A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_concert');
        $this->addSql('DROP TABLE category_festival');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE festival');
        $this->addSql('DROP TABLE festival_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_concert');
    }
}
