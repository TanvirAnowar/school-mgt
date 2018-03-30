<?php
/**
 * Created by PhpStorm.
 * User: Tanvir Anowar
 * Date: 7/8/14
 * Time: 3:44 PM
 */

class MessageSystem {

    public static function saveDiscussion($senderId)
    {
        if(Request::isMethod('post'))
        {
            $users = Input::get('users');
            $subject = Input::get('subject');
            $message = Input::get('message');

            $discussion = new Discussion();
            $discussion->subject = $subject;
            $discussion->details = $message;
            $discussion->status = 1;
            $discussion->sender_id = $senderId;
            $discussion->receivers = implode(",",$users);
            $fileName = '';
            if(Input::hasFile('attachment'))
            {
                $ext = Input::file('attachment')->getClientOriginalExtension();
                $name = Input::file('attachment')->getClientOriginalName();
                $path = 'data/attachment/';
                $prefix = time();
                $name = $prefix.'_'.$name;
                if(in_array($ext,array('jpg','png','gif','txt','pdf','doc','xls','ppt')))
                {
                    Input::file('attachment')->move($path,$name);

                }
                $fileName = $name;
            }
            $discussion->attachment = $fileName;
            $discussion->save();
            if($discussion->discussion_id)
            {
                foreach($users as $user)
                {
                   $notice = new Comment();
                   $notice->discussion_id = $discussion->discussion_id;
                   $notice->sender_id = $senderId;
                   $notice->receiver_id = $user;
                   $notice->message = $discussion->subject;
                   $notice->read_status = 0;
                   $notice->type = 'Notification';
                   $notice->save();
                }
                return array('status'=>200,'msg'=>'Message Sent');
            }
            return array('status'=>400,'msg'=>'Sorry! Message Sent');
        }else{
            return array('status'=>500,'msg'=>'Bad Request');
        }
    }

    public static function countNotification()
    {

    }

    public static function commentToDiscussion()
    {
        if(Request::isMethod('post'))
        {
            $discussion = Input::get('discussion');
            $receiver = Input::get('receiver');     // who will get notification
            $sender = Input::get('sender');         // person who comment it
            $message = Input::get('message');
            $url = Input::get('url');

            // reply
            $comment = new Comment();
            $comment->discussion_id = $discussion;
            $comment->sender_id = $sender;
            $comment->receiver_id = $receiver;
            $comment->message = $message;
            $comment->type = 'Comment';
            $comment->read_status = 1;
            $fileName = '';
            if(Input::hasFile('attachment'))
            {
                $ext = Input::file('attachment')->getClientOriginalExtension();
                $name = Input::file('attachment')->getClientOriginalName();
                $path = 'data/attachment/';
                $prefix = time();
                $name = $prefix.'_'.$name;
                if(in_array($ext,array('jpg','png','gif','txt','pdf','doc','xls','ppt')))
                {
                    Input::file('attachment')->move($path,$name);

                }
                $fileName = $name;
            }

            $comment->attachment = $fileName;
            $comment->save();

            // notify

            $discussObj = Discussion::find($discussion);
            $user = User::find($sender);
            if($comment->sender_id != $discussObj->sender_id)
            {

                $comment = new Comment();
                $comment->discussion_id = $discussion;
                $comment->sender_id = $sender;
                $comment->receiver_id = $receiver;
                $comment->message = $user->username .' commented on '. $discussObj->subject;
                $comment->type = 'Notification';
                $comment->read_status = 0;
                $comment->save();

            }else{
                $comments = $discussObj->Comments;
                if(count($comments))
                {
                    foreach($comments as $c)
                    {
                        if($c->sender_id == $comment->sender_id)
                        {
                            continue;
                        }

                        $comment = new Comment();
                        $comment->discussion_id = $discussion;
                        $comment->sender_id = $sender;
                        $comment->receiver_id = $c->sender_id;
                        $comment->message = $user->username .' commented on '. $discussObj->subject;
                        $comment->type = 'Notification';
                        $comment->read_status = 0;
                        $comment->save();
                    }
                }
            }

            return array('status'=>200,'msg'=>' Reply sent','refurl'=>$url);
        }else{
            return array('status'=>500, 'msg'=>' Bad Request','refurl'=>'');
        }
    }
} 