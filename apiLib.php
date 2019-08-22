<?php

require __DIR__ . '/vendor/autoload.php';

class apiLib
{
    private $instagram;
    private $username;
    private $isPrivate;
    function __construct($username)
    {
        $this->username = $username;
        // $this->instagram = new \InstagramScraper\Instagram();
        $this->instagram = \InstagramScraper\Instagram::withCredentials('username', 'password');
        $this->instagram->login();
    }

    function getPrivacy()
    {
        $account = $this->instagram->getAccount($this->username);
        $this->isPrivate = $account->isPrivate();
        print_r($account);
        print_r($this->isPrivate);
    }

    function getAccount()
    {
        $account = $this->instagram->getAccount($this->username);

        return [
            "id" => $account->getId(),
            "username" => $account->getUsername(),
            "fullName" => $account->getfullName(),
            "profilePicUrl" => $account->getprofilePicUrl(),
            "followedByCount" => $account->getfollowedByCount(),
            "mediaCount" => $account->getmediaCount(),
            "medias" => $this->getMedias()
        ];
    }

    function getMedias()
    {
        $mediaArray = [];

        $result = $this->instagram->getPaginateMedias($this->username);


        $medias = $result['medias'];
        if ($result['hasNextPage'] === true) {
            $result = $this->instagram->getPaginateMedias($this->username, $result['maxId']);
            $medias = array_merge($medias, $result['medias']);
        }

        foreach ($medias as $media) {
            $mediaArray[] = [
                "id" => $media->getId(),
                "shortCode" => $media->getshortCode(),
                "likesCount" => $media->getlikesCount(),
                "imageThumbnailUrl" => $media->getimageThumbnailUrl(),
                "link" => $media->getlink()
            ];
        }


        return $mediaArray;
    }
}
