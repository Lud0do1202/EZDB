<?php

class MY_DB
{
	const USERS = 'users';
	const USERS_ID = 'id';
	const USERS_USERNAME = 'username';
	const USERS_PASSWORD = 'password';
	const USERS_CREATED_AT = 'created_at';
	/*********************************/
	const POSTS = 'posts';
	const POSTS_ID = 'id';
	const POSTS_TITLE = 'title';
	const POSTS_CONTENT = 'content';
	const POSTS_USER_ID = 'user_id';
	const POSTS_CREATED_AT = 'created_at';
	/*********************************/
	const COMMENTS = 'comments';
	const COMMENTS_ID = 'id';
	const COMMENTS_CONTENT = 'content';
	const COMMENTS_POST_ID = 'post_id';
	const COMMENTS_USER_ID = 'user_id';
	const COMMENTS_CREATED_AT = 'created_at';
	/*********************************/
	const NO_COLUMN = 'NoColumn';
	/*********************************/
}
