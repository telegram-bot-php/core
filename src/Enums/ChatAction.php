<?php

namespace TelegramBot\Enums;

/**
 * ChatAction class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class ChatAction
{

    /**
     * Typing chat action
     */
    public const TYPING = 'typing';

    /**
     * Upload Photo chat action
     */
    public const UPLOAD_PHOTO = 'upload_photo';

    /**
     * Record Video chat action
     */
    public const RECORD_VIDEO = 'record_video';

    /**
     * Upload Video chat action
     */
    public const UPLOAD_VIDEO = 'upload_video';

    /**
     * Record Voice chat action
     */
    public const RECORD_VOICE = 'record_voice';

    /**
     * Upload Voice chat action
     */
    public const UPLOAD_VOICE = 'upload_voice';

    /**
     * Upload Document chat action
     */
    public const UPLOAD_DOCUMENT = 'upload_document';

    /**
     * Choose Sticker chat action
     */
    public const CHOOSE_STICKER = 'choose_sticker';

    /**
     * Find Location chat action
     */
    public const FIND_LOCATION = 'find_location';

    /**
     * Record Video Note chat action
     */
    public const RECORD_VIDEO_NOTE = 'record_video_note';

    /**
     * Upload Video note chat action
     */
    public const UPLOAD_VIDEO_NOTE = 'upload_video_note';

}
