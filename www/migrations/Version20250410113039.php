<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410113039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, device_type_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, INDEX IDX_92FB68E54177093 (room_id), INDEX IDX_92FB68E4FFA550E (device_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE device_setting (id INT AUTO_INCREMENT NOT NULL, vibe_id INT DEFAULT NULL, device_id INT DEFAULT NULL, setting_type_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_15C261054B255BC3 (vibe_id), INDEX IDX_15C2610594A4C7D4 (device_id), INDEX IDX_15C261059D1E3C7B (setting_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE device_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, vibe_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, recurrence VARCHAR(50) NOT NULL, INDEX IDX_3BAE0AA74B255BC3 (vibe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D782112D3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE playlist_song (playlist_id INT NOT NULL, song_id INT NOT NULL, INDEX IDX_93F4D9C36BBD148 (playlist_id), INDEX IDX_93F4D9C3A0BDB2F3 (song_id), PRIMARY KEY(playlist_id, song_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, username VARCHAR(100) NOT NULL, password VARCHAR(4) NOT NULL, INDEX IDX_8157AA0F3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_729F519B3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE room_event (room_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_7112AB0C54177093 (room_id), INDEX IDX_7112AB0C71F7E88B (event_id), PRIMARY KEY(room_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, data_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, duration DATETIME NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE vibe (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, image_id INT DEFAULT NULL, playlist_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, energy VARCHAR(255) NOT NULL, stress VARCHAR(255) NOT NULL, motivation VARCHAR(255) NOT NULL, INDEX IDX_42054C01CCFA12B8 (profile_id), UNIQUE INDEX UNIQ_42054C013DA5256D (image_id), INDEX IDX_42054C016BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device ADD CONSTRAINT FK_92FB68E54177093 FOREIGN KEY (room_id) REFERENCES room (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device ADD CONSTRAINT FK_92FB68E4FFA550E FOREIGN KEY (device_type_id) REFERENCES device_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device_setting ADD CONSTRAINT FK_15C261054B255BC3 FOREIGN KEY (vibe_id) REFERENCES vibe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device_setting ADD CONSTRAINT FK_15C2610594A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device_setting ADD CONSTRAINT FK_15C261059D1E3C7B FOREIGN KEY (setting_type_id) REFERENCES setting_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA74B255BC3 FOREIGN KEY (vibe_id) REFERENCES vibe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlist ADD CONSTRAINT FK_D782112D3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlist_song ADD CONSTRAINT FK_93F4D9C36BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlist_song ADD CONSTRAINT FK_93F4D9C3A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room ADD CONSTRAINT FK_729F519B3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_event ADD CONSTRAINT FK_7112AB0C54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_event ADD CONSTRAINT FK_7112AB0C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe ADD CONSTRAINT FK_42054C01CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe ADD CONSTRAINT FK_42054C013DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe ADD CONSTRAINT FK_42054C016BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE device DROP FOREIGN KEY FK_92FB68E54177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device DROP FOREIGN KEY FK_92FB68E4FFA550E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device_setting DROP FOREIGN KEY FK_15C261054B255BC3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device_setting DROP FOREIGN KEY FK_15C2610594A4C7D4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE device_setting DROP FOREIGN KEY FK_15C261059D1E3C7B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA74B255BC3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlist_song DROP FOREIGN KEY FK_93F4D9C36BBD148
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE playlist_song DROP FOREIGN KEY FK_93F4D9C3A0BDB2F3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room DROP FOREIGN KEY FK_729F519B3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_event DROP FOREIGN KEY FK_7112AB0C54177093
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE room_event DROP FOREIGN KEY FK_7112AB0C71F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe DROP FOREIGN KEY FK_42054C01CCFA12B8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe DROP FOREIGN KEY FK_42054C013DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vibe DROP FOREIGN KEY FK_42054C016BBD148
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE device
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE device_setting
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE device_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE playlist
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE playlist_song
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE profile
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE room_event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE setting_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE song
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE vibe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
