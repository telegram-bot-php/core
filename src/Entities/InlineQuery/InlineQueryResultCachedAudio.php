<?php

namespace TelegramBot\Entities\InlineQuery;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InputMessageContent\InputMessageContent;
use TelegramBot\Entities\MessageEntity;

/**
 * Class InlineQueryResultCachedAudio
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedaudio
 *
 * <code>
 * $data = [
 *   'id'                    => '',
 *   'audio_file_id'         => '',
 *   'caption'               => '',
 *   'reply_markup'          => <InlineKeyboard>,
 *   'input_message_content' => <InputMessageContent>,
 * ];
 * </code>
 *
 * @method string               getType()                Type of the result, must be audio
 * @method string               getId()                  Unique identifier for this result, 1-64 bytes
 * @method string               getAudioFileId()         A valid file identifier for the audio file
 * @method string               getCaption()             Optional. Caption, 0-200 characters
 * @method string               getParseMode()           Optional. Mode for parsing entities in the audio caption
 * @method MessageEntity[]      getCaptionEntities()     Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method InlineKeyboard       getReplyMarkup()         Optional. An Inline keyboard attached to the message
 * @method InputMessageContent  getInputMessageContent() Optional. Content of the message to be sent instead of the audio
 *
 * @method $this setId(string $id)                                                  Unique identifier for this result, 1-64 bytes
 * @method $this setAudioFileId(string $audio_file_id)                              A valid file identifier for the audio file
 * @method $this setCaption(string $caption)                                        Optional. Caption, 0-200 characters
 * @method $this setParseMode(string $parse_mode)                                   Optional. Mode for parsing entities in the audio caption
 * @method $this setCaptionEntities(array $caption_entities)                        Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
 * @method $this setReplyMarkup(InlineKeyboard $reply_markup)                       Optional. An Inline keyboard attached to the message
 * @method $this setInputMessageContent(InputMessageContent $input_message_content) Optional. Content of the message to be sent instead of the audio
 */
class InlineQueryResultCachedAudio extends InlineEntity implements InlineQueryResult
{

    /**
     * InlineQueryResultCachedAudio constructor
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $data['type'] = 'audio';
        parent::__construct($data);
    }

}
