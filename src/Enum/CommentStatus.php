<?php

namespace Blog\Enum;


enum CommentStatus: string
{
    case Pending = "pending";
    case Approved = "approved";
    case Deleted = "deleted";
}
