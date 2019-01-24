<?php
class AnilistPage extends Controller {
	private $TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjU5YTAxZTIwODZiY2IwMjZlZmU3YjdkZDc0MmQ1ODAwZTI1YjY4NDg4YzE1OTgzNDRkMTNiNzE5ODhhZWNiNjBmNjNlOGZmMjFhYmZjNzc3In0.eyJhdWQiOiI5NDIiLCJqdGkiOiI1OWEwMWUyMDg2YmNiMDI2ZWZlN2I3ZGQ3NDJkNTgwMGUyNWI2ODQ4OGMxNTk4MzQ0ZDEzYjcxOTg4YWVjYjYwZjYzZThmZjIxYWJmYzc3NyIsImlhdCI6MTUzNTMxNTQxNywibmJmIjoxNTM1MzE1NDE3LCJleHAiOjE1NjY4NTE0MTcsInN1YiI6IjE3MjU2NiIsInNjb3BlcyI6W119.GOXy-8szDCsDy-Fr0Djl-l5Pdu928WjlrlJ3WGwcG-pOf2MCt12owe4B36l4T5wIPoup8W6EuaxkSGjxQVVKlERXuio_ximI_qDS6rn038rUvEk-g1v6UYyM1ZMvmSEixMmxM3NI7cTjNWOHOnDNqj_YgtaQw7X9aJfAU-jhMfCdVTfKP_wQo7Mxx6jzHGvHH5stNCIWaQBcO8PMeCvD11516RBoFa_GwiaYm2eXjTlY4_18_k13pkMMgEs3lucwroH24GISZov2IbWEyKhAuxkt3v3aBhnwB11SSl1GzHXFvS-aR4kSfdE1xRIPJxDxHwy9jGlnI1srDR8frlEaYb0FgAb13ASoXfyKgy9o9LprfynvnDQv3ABFnwmo6HzavzPdFNH7XYRGiS8tahW58kZQhwwZKVTl6Ey3TGv34SqMqO_NEi1padu5GTlLz1G60ND4PFOJ4b3DOvxV3sAz7VjpL4Bp8QZtYPAhwXyJQpNXKhuLVKnBk0EKtWn2JXfjroxSDnklPHrQUd4Q0WZAyu7H6Gwu5vYO-gcQz893rjKKJsj1Z7r8ansKf9-cAd0UDCP5jLYajXWJeXVf9wRq6o09Gi_eQiqgRA5U_V1Olm4TiuR5Zy39dUXqo9lJ22t3W6PsXZ2G1YEsrkU55jLRkqu0JA6pOF96lY3FbFS0c0E";

	public $data = array();
	public function run ($viewName) {
			//$this->updateDatabase();
			if (isset($_GET['search'])) {
				$this->searchAnilistUserNameLocal($_GET['search']);
			}
			else {
				$this->searchAnilistUserNameLocal('Ninio');
			}
			self::render($viewName,$this->data);
	}

	public function searchAnilistUserNameLocal($UserName){
		$result = self::query('SELECT l.* FROM anilistOthers AS l
			INNER JOIN anilistUsers AS u ON (u.id = l.userID) 
			WHERE u.userName = ? AND l.lastUpdate > DATE_SUB(NOW(), INTERVAL 1 HOUR)
			ORDER BY status ASC, score DESC, title ASC',array($UserName));
		if (!empty($result)) {
			//var_dump($UserName);
			$this->data['anime'] = $result;
		}else {
			$this->data['anime'] = $this->searchAnilistUserName($UserName);
		}
	}

	public function searchAnilistUserName($UserName) {
$query = <<<'JSON'
query ($name: String, $listType: MediaType) {
  MediaListCollection (userName: $name, type: $listType) {
    lists {
      name
      isCustomList
      isSplitCompletedList
      entries {
        ... mediaListEntry
      }
    }
    user {
      id
      name 
      avatar {
        large
      }
      mediaListOptions {
        scoreFormat
        rowOrder
      }
    }
  }
}

fragment mediaListEntry on MediaList {
  id
  score
  scoreRaw: score (format: POINT_100)
  progress
  progressVolumes
  repeat
  private
  priority
  notes
  hiddenFromStatusLists
  startedAt {
    year
    month
    day
  }
  completedAt {
    year
    month
    day
  }
  updatedAt
  createdAt
  media {
    id
    title {
      userPreferred
    }
    coverImage {
    	large
    }
  }
}
JSON;
$variables = array('name' => $UserName,
					'listType' => 'ANIME');


$json = json_encode(['query' => $query, 'variables' => $variables]);

$chObj = curl_init();
curl_setopt($chObj, CURLOPT_URL, 'https://graphql.anilist.co');
curl_setopt($chObj, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chObj, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($chObj, CURLOPT_HEADER, true);
curl_setopt($chObj, CURLOPT_VERBOSE, true);
curl_setopt($chObj, CURLOPT_POSTFIELDS, $json);
curl_setopt($chObj, CURLOPT_HTTPHEADER,
array(
'User-Agent: PHP Script',
'Content-Type: application/json;',
'Accept: application/json',
'Authorization: Bearer '.$this->TOKEN.';'
)
);


$response = curl_exec($chObj);

// Then, after your curl_exec call:
$header_size = curl_getinfo($chObj, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
curl_close($chObj);
//var_dump($response);
$result = json_decode($body);
if ($result != null) {
//var_dump($body);
//var_dump($result->data->MediaListCollection->user->id); userId
$userId = $result->data->MediaListCollection->user->id;


self::query('DELETE l.*,u.* FROM anilistOthers AS l
			INNER JOIN anilistUsers AS u ON (u.id = l.userID) 
			WHERE u.userName = ?',array($UserName));

self::query('INSERT IGNORE INTO anilistUsers (id,userName) VALUES (?,?)',
			array($userId,$UserName));
foreach ($result->data->MediaListCollection->lists as $list) {
	//var_dump($list->name); status
	//var_dump($list);
	$status = $list->name;
	foreach ($list->entries as $anime) {
		//var_dump($anime->media->title->userPreferred); Title
		//var_dump($anime->media->coverImage->large); image Src
		//var_dump($anime->score); score
		//var_dump($anime);
		$title = $anime->media->title->userPreferred;
		$image = $anime->media->coverImage->large;
		$score = $anime->score/10;
		self::query('INSERT IGNORE INTO anilistOthers (title,score,image,status,lastUpdate,userId) VALUES (?,?,?,?,NOW(),?)',
			array($title,$score,$image,$status,$userId));
	}
}

$resultQuery = self::query('SELECT l.* FROM anilistOthers AS l
		INNER JOIN anilistUsers AS u ON (u.id = l.userID) 
		WHERE u.userName = ? AND l.lastUpdate > DATE_SUB(NOW(), INTERVAL 1 HOUR)
		ORDER BY status ASC, score DESC, title ASC',array($UserName));

		return $resultQuery;

}else {
	return null;
}

	}
}