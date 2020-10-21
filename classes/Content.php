<?php

class Content { //content class 

	private $conn;
	private $uploadsTable = 'sirimazone_uploads';
	private $contentsTable = 'sirimazone_contents';
	private $commentsTable = 'sirimazone_comments';

	/*private $adminTable = 'sirimazone_admins';
	private $accessIdTable = 'sirimazone_access_id';*/
	
	//constructor with database
	public function __construct($db) {
		$this->conn = $db;
	}

	public function convertByteInString($val) {
		if ($val < 1048576) {
			$convertedVal = number_format($val / 1024, 2).'kb';
			if(substr($convertedVal, -4) == '00kb') {
				return (substr($convertedVal, 0, -5).'kb');
			} else {
				return $convertedVal;
			}
		} else if ($val >= 1048576) {
			$convertedVal = number_format($val / 1048576, 2).'mb';
			if(substr($convertedVal, -4) == '00mb') {
				return (substr($convertedVal, 0, -5).'mb');
			} else {
				return $convertedVal;
			}
		}
	}


	public function uploadToSQL($fileName, $fileExt, $fileSize, $uploader) {

		//set query
		$query = "INSERT INTO ". $this->uploadsTable ."(`file_name`, `file_extension`, `file_size`, `uploaded_by`) VALUES (:file_name, :file_extension, :file_size, :uploaded_by)";

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':file_name', $fileName);
		$stmt->bindValue(':file_extension', $fileExt);
		$stmt->bindValue(':file_size', $fileSize);
		$stmt->bindValue(':uploaded_by', $uploader);

		// Execute query
		if($stmt->execute()) {
			return true;
		}

		return false;

	}


	public function getAllUploadedFiles() {

		$query = 'SELECT * FROM '.$this->uploadsTable;

		//prepare statement
		$stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;

	}

	public function getUploadsBy($username = null) {

		$query = 'SELECT * FROM '.$this->uploadsTable.' WHERE '.$this->uploadsTable.'.uploaded_by = :uploader';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':uploader', $username);

		//execute query
		$stmt->execute();

		return $stmt;

	}

	public function getImageUploads() {

		$query = 'SELECT * FROM '.$this->uploadsTable.' WHERE file_extension = "jpeg" OR file_extension = "jpg" OR file_extension = "png" OR file_extension = "gif"';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		return $stmt;

	}

	public function getNonImageUploads() {

		$query = 'SELECT * FROM '.$this->uploadsTable.' WHERE file_extension = "mp3" OR file_extension = "3gp" OR file_extension = "mp4" OR file_extension = "mkv"';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		return $stmt;

	}


	public function getAllContentPost() {

		$query = 'SELECT * FROM '.$this->contentsTable;

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}

	public function getAllContentPostByUser($username) {
		
		$query = 'SELECT * FROM '.$this->contentsTable . ' WHERE content_author = :username';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':username', $username);

		//execute query
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}


	public function getPublishedContentPost() {

		$query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1"';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		return $stmt;

	}

	public function getPinnedPublishedContentPost() {

		$query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1" AND is_pinned = "1" ORDER BY `id` DESC';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute query
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}

	public function getPublishedContentPostWithLimit($startLimit, $resultsPerPage) {

		// $query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1" LIMIT :startLimit , :resultsPerPage';

		$query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1"  ORDER BY `id` DESC LIMIT ' . $startLimit . ' , '. $resultsPerPage;

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		// $stmt->bindValue(':startLimit', $startLimit);
		// $stmt->bindValue(':resultsPerPage', $resultsPerPage);

		//execute query
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}


	public function getPublishedCatPostWithLimit($category, $startLimit, $resultsPerPage) {

		// $query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1" LIMIT :startLimit , :resultsPerPage';

		$query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1" AND content_category = :category ORDER BY `id` DESC LIMIT ' . $startLimit . ' , '. $resultsPerPage;

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':category', $category);
		// $stmt->bindValue(':resultsPerPage', $resultsPerPage);

		//execute query
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}




	public function getPublishedContentPostBy($username) {

		$query = 'SELECT * FROM '.$this->contentsTable. ' WHERE is_published = "1" AND content_author = :username';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':username', $username);

		//execute query
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}


	public function getPublishedPostByCat($category) {

		$query = 'SELECT * FROM '. $this->contentsTable . ' WHERE is_published = "1" AND content_category = :category';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':category', $category);

		//execute
		$stmt->execute();

		//fetch array of post by category
		$result = $stmt->fetchAll();

		return $result;

	}


	public function checkForDuplicatePosts($title) {

		$query = 'SELECT * FROM '.$this->contentsTable. ' WHERE content_title = :title';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':title', $title);

		//execute statement
		$stmt->execute();

		//fetch array length
		$result = count($stmt->fetchAll());


		return $result;

	}

	public function getPostBySlug($slug) {

		$query = 'SELECT * FROM '. $this->contentsTable. ' WHERE content_slug = :slug LIMIT 1';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':slug', $slug);

		//execute statement
		$stmt->execute();

		//fetch array
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		//return array
		return $result;

	}

	public function getPostBySearchQuery($likePart) {

		$query = 'SELECT * FROM '.$this->contentsTable . ' WHERE is_published = "1" AND (' . $likePart .') ORDER BY `id` DESC';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute statement
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}


	public function getPostBySearchQueryWithLimit($likePart, $startLimit, $resultsPerPage) {

		$query = 'SELECT * FROM '.$this->contentsTable . ' WHERE is_published = "1" AND (' . $likePart .') ORDER BY `id` DESC LIMIT ' . $startLimit . ', '. $resultsPerPage;

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute statement
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		return $result;

	}



	public function getFilesizeByFilename($filename) {

		$query = 'SELECT file_size FROM ' . $this->uploadsTable . ' WHERE file_name = :filename';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':filename', $filename);

		//execute statement
		$stmt->execute();

		//fetch array
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		//return array
		return $result;		

	}

	public function getAllPublishedPostsSlug() {

		$query = 'SELECT content_slug FROM '. $this->contentsTable. ' WHERE is_published = "1"';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//execute statement
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		//return array
		return $result;

	}

	public function getAllPostCommentsBySlug($postSlug) {

		$query = 'SELECT * FROM '. $this->commentsTable. ' WHERE post_slug = :post_slug';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':post_slug', $postSlug);

		//execute statement
		$stmt->execute();

		//fetch array
		$result = $stmt->fetchAll();

		//return array
		return $result;

	}

	public function deleteContentPostBySlug($postSlug) {

		$query = 'DELETE FROM '. $this->contentsTable .' WHERE content_slug = :post_slug';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':post_slug', $postSlug);

		//execute statement
		if($stmt->execute()) {
			return true;
		}


		return false;

	}


	public function deletePostCommentByCommentID($commentID) {

		$query = 'DELETE FROM '. $this->commentsTable .' WHERE comment_id = :commentID';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':commentID', $commentID);

		//execute statement
		if($stmt->execute()) {
			return true;
		}


		return false;

	}


	public function deleteFileFromSQL($fileName) {

		$query = 'DELETE FROM '.$this->uploadsTable.' WHERE file_name = :file_name';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':file_name', $fileName);

		//execute query
		if($stmt->execute()) {
			return true;
		}

		return false;

	}


	public function createSlug($strVal) {

		//replace all non word characters with space
		$removeNonWordChar = preg_replace('/\W+/', ' ', strtolower($strVal));

		//remove underscores
		$removeUnderscores = str_replace('_', ' ', $removeNonWordChar);

		//replace all space with single dash
		$replaceSpace = preg_replace('/\s+/', '-', trim($removeUnderscores));

		//generate a 6 digit random value for post identification
		$randVal = substr(uniqid(), -3).rand(1, 999);

		$slug = $replaceSpace.'-'.$randVal;

		return $slug;


	}

	public function insertCommentToDB($commentID, $postTitle, $postSlug, $commentAuthor, $commentBody, $creationTimestamp) {

		$query = 'INSERT INTO '.$this->commentsTable.'(
				`comment_id`, 
				`post_title`, 
				`post_slug`, 
				`comment_author`, 
				`comment_body`, 
				`creation_timestamp`
			) VALUES (
				:comment_id, 
				:post_title, 
				:post_slug, 
				:comment_author, 
				:comment_body, 
				:creation_timestamp
			)';


		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':comment_id', $commentID);
		$stmt->bindValue(':post_title', $postTitle);
		$stmt->bindValue(':post_slug', $postSlug);
		$stmt->bindValue(':comment_author', $commentAuthor);
		$stmt->bindValue(':comment_body', $commentBody);
		$stmt->bindValue(':creation_timestamp', $creationTimestamp);


		//execute query
		if($stmt->execute()) {
			return true;
		}

		return false;



	}


	public function insertPostToDB(
		$contentTitle,
		$contentSlug, 
		$contentCoverImage,
		$contentCoverImageAlt,
		$contentCategory,
		$contentAuthor,
		$contentMainFile,
		$contentMainFileExtServer,
		$contentOverview,
		$contentCasts,
		$isPublished,
		$createdAt 
		) {

		$query = 'INSERT INTO '.$this->contentsTable.'(
				`content_title`, 
				`content_slug`, 
				`content_cover_image`, 
				`content_cover_image_alt`, 
				`content_category`, 
				`content_author`,
				`content_main_file`, 
				`content_main_file_ext_server`,
				`content_overview`,
				`content_casts`,
				`is_published`,
				`created_at` 
			) VALUES (
				:content_title, 
				:content_slug, 
				:content_cover_image, 
				:content_cover_image_alt, 
				:content_category, 
				:content_author,
				:content_main_file, 
				:content_main_file_ext_server,
				:content_overview,
				:content_casts,
				:is_published,
				:created_at
			)';

		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':content_title', $contentTitle);
		$stmt->bindValue(':content_slug', $contentSlug);
		$stmt->bindValue(':content_cover_image', $contentCoverImage);
		$stmt->bindValue(':content_cover_image_alt', $contentCoverImageAlt);
		$stmt->bindValue(':content_category', $contentCategory);
		$stmt->bindValue(':content_author', $contentAuthor);
		$stmt->bindValue(':content_main_file', $contentMainFile);
		$stmt->bindValue(':content_main_file_ext_server', $contentMainFileExtServer);
		$stmt->bindValue(':content_overview', $contentOverview);
		$stmt->bindValue(':content_casts', $contentCasts);
		$stmt->bindValue(':is_published', $isPublished);
		$stmt->bindValue(':created_at', $createdAt);

		//execute query
		if($stmt->execute()) {
			return true;
		}

		return false;
	}


/*
UPDATE `sirimazone_contents` SET `content_cover_image_alt` = 'The Island movie\'s cover image', `content_overview` = 'the movie about an island that got wrecked and all', `content_casts` = 'zombie, chiboy, prisci, glory, osato, henry, all of the above' WHERE `sirimazone_contents`.`id` = 3; 

*/

	public function updateContentPostInDB(
		$id,
		$contentTitle,
		$contentSlug, 
		$contentCoverImage,
		$contentCoverImageAlt,
		$contentCategory,
		$contentMainFile,
		$contentMainFileExtServer,
		$contentOverview,
		$contentCasts,
		$isPublished,
		$isPinned,
		$updatedAt 
		) {

		$query = 'UPDATE '.$this->contentsTable.' SET
				`content_title` = :content_title,
				`content_slug` = :content_slug,
				`content_cover_image` = :content_cover_image,
				`content_cover_image_alt` = :content_cover_image_alt,
				`content_category` = :content_category,
				`content_main_file` = :content_main_file,
				`content_main_file_ext_server` = :content_main_file_ext_server,
				`content_overview` = :content_overview,
				`content_casts` = :content_casts,
				`is_published` = :is_published,
				`is_pinned` = :is_pinned,
				`updated_at` = :updated_at
			WHERE '. $this->contentsTable .'.`id` = :id';


		//prepare statement
		$stmt = $this->conn->prepare($query);

		//bind values
		$stmt->bindValue(':id', $id);
		$stmt->bindValue(':content_title', $contentTitle);
		$stmt->bindValue(':content_slug', $contentSlug);
		$stmt->bindValue(':content_cover_image', $contentCoverImage);
		$stmt->bindValue(':content_cover_image_alt', $contentCoverImageAlt);
		$stmt->bindValue(':content_category', $contentCategory);
		$stmt->bindValue(':content_main_file', $contentMainFile);
		$stmt->bindValue(':content_main_file_ext_server', $contentMainFileExtServer);
		$stmt->bindValue(':content_overview', $contentOverview);
		$stmt->bindValue(':content_casts', $contentCasts);
		$stmt->bindValue(':is_published', $isPublished);
		$stmt->bindValue(':is_pinned', $isPinned);
		$stmt->bindValue(':updated_at', $updatedAt);

		//execute query
		if($stmt->execute()) {
			return true;
		}

		return false;

	}





}