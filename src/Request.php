<?php

namespace TelegramBot;

use EasyHttp\Client;
use EasyHttp\FormData;
use TelegramBot\Entities\Response;
use TelegramBot\Exception\InvalidBotTokenException;
use TelegramBot\Exception\TelegramException;
use TelegramBot\Util\Toolkit;

/**
 * Request class
 *
 *
 * Getting updates
 * There are two mutually exclusive ways of receiving updates for your bot — the getUpdates method on one hand and Webhooks on the other. Incoming updates are stored on the server until the bot receives them either way, but they will not be kept longer than 24 hours.
 *
 * @method static Response getUpdates(array $data)      Use this method to receive incoming updates using long polling (wiki). An Array of Update objects is returned.
 * @method static Response setWebhook(array $data)      Use this method to specify a url and receive incoming updates via an outgoing webhook. Whenever there is an update for the bot, we will send an HTTPS POST request to the specified url, containing a JSON-serialized Update. In case of an unsuccessful request, we will give up after a reasonable amount of attempts. Returns true.
 * @method static Response deleteWebhook(array $data)   Use this method to remove webhook integration if you decide to switch back to getUpdates. Returns True on success.
 * @method static Response getWebhookInfo()             Use this method to get current webhook status. Requires no parameters. On success, returns a WebhookInfo object. If the bot is using getUpdates, will return an object with the url field empty.
 *
 *
 * Available methods
 * All methods in the Bot API are case-insensitive.
 *
 * @method static Response getMe()                                        A simple method for testing your bots auth token. Requires no parameters. Returns basic information about the bot in form of a User object.
 * @method static Response logOut()                                       Use this method to log out from the cloud Bot API server before launching the bot locally. Requires no parameters. Returns True on success.
 * @method static Response close()                                        Use this method to close the bot instance before moving it from one local server to another. Requires no parameters. Returns True on success.
 * @method static Response sendMessage(array $data)                       Use this method to send any kind of message. On success, the sent Message is returned.
 * @method static Response forwardMessage(array $data)                    Use this method to forward messages of any kind. On success, the sent Message is returned.
 * @method static Response copyMessage(array $data)                       Use this method to copy messages of any kind. The method is analogous to the method forwardMessages, but the copied message doesn't have a link to the original message. Returns the MessageId of the sent message on success.
 * @method static Response sendPhoto(array $data)                         Use this method to send photos. On success, the sent Message is returned.
 * @method static Response sendAudio(array $data)                         Use this method to send audio files, if you want Telegram clients to display them in the music player. Your audio must be in the .mp3 format. On success, the sent Message is returned. Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
 * @method static Response sendDocument(array $data)                      Use this method to send general files. On success, the sent Message is returned. Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
 * @method static Response sendVideo(array $data)                         Use this method to send video files, Telegram clients support mp4 videos (other formats may be sent as Document). On success, the sent Message is returned. Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
 * @method static Response sendAnimation(array $data)                     Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound). On success, the sent Message is returned. Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
 * @method static Response sendVoice(array $data)                         Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message. For this to work, your audio must be in an .ogg file encoded with OPUS (other formats may be sent as Audio or Document). On success, the sent Message is returned. Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
 * @method static Response sendVideoNote(array $data)                     Use this method to send video messages. On success, the sent Message is returned.
 * @method static Response sendMediaGroup(array $data)                    Use this method to send a group of photos or videos as an album. On success, an array of the sent Messages is returned.
 * @method static Response sendLocation(array $data)                      Use this method to send point on the map. On success, the sent Message is returned.
 * @method static Response editMessageLiveLocation(array $data)           Use this method to edit live location messages sent by the bot or via the bot (for inline bots). A location can be edited until its live_period expires or editing is explicitly disabled by a call to stopMessageLiveLocation. On success, if the edited message was sent by the bot, the edited Message is returned, otherwise True is returned.
 * @method static Response stopMessageLiveLocation(array $data)           Use this method to stop updating a live location message sent by the bot or via the bot (for inline bots) before live_period expires. On success, if the message was sent by the bot, the sent Message is returned, otherwise True is returned.
 * @method static Response sendVenue(array $data)                         Use this method to send information about a venue. On success, the sent Message is returned.
 * @method static Response sendContact(array $data)                       Use this method to send phone contacts. On success, the sent Message is returned.
 * @method static Response sendPoll(array $data)                          Use this method to send a native poll. A native poll can't be sent to a private chat. On success, the sent Message is returned.
 * @method static Response sendDice(array $data)                          Use this method to send a dice, which will have a random value from 1 to 6. On success, the sent Message is returned.
 * @method static Response sendChatAction(array $data)                    Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status). Returns True on success.
 * @method static Response getUserProfilePhotos(array $data)              Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.
 * @method static Response getFile(array $data)                           Use this method to get basic info about a file and prepare it for downloading. For the moment, bots can download files of up to 20MB in size. On success, a File object is returned. The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>, where <file_path> is taken from the response. It is guaranteed that the link will be valid for at least 1 hour. When the link expires, a new one can be requested by calling getFile again.
 * @method static Response banChatMember(array $data)                     Use this method to kick a user from a group, a supergroup or a channel. In the case of supergroups and channels, the user will not be able to return to the group on their own using invite links, etc., unless unbanned first. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
 * @method static Response unbanChatMember(array $data)                   Use this method to unban a previously kicked user in a supergroup or channel. The user will not return to the group or channel automatically, but will be able to join via link, etc. The bot must be an administrator for this to work. Returns True on success.
 * @method static Response restrictChatMember(array $data)                Use this method to restrict a user in a supergroup. The bot must be an administrator in the supergroup for this to work and must have the appropriate admin rights. Pass True for all permissions to lift restrictions from a user. Returns True on success.
 * @method static Response promoteChatMember(array $data)                 Use this method to promote or demote a user in a supergroup or a channel. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Pass False for all boolean parameters to demote a user. Returns True on success.
 * @method static Response setChatAdministratorCustomTitle(array $data)   Use this method to set a custom title for an administrator in a supergroup promoted by the bot. Returns True on success.
 * @method static Response banChatSenderChat(array $data)                 Use this method to ban a channel chat in a supergroup or a channel. Until the chat is unbanned, the owner of the banned chat won't be able to send messages on behalf of any of their channels. The bot must be an administrator in the supergroup or channel for this to work and must have the appropriate administrator rights. Returns True on success.
 * @method static Response unbanChatSenderChat(array $data)               Use this method to unban a previously banned channel chat in a supergroup or channel. The bot must be an administrator for this to work and must have the appropriate administrator rights. Returns True on success.
 * @method static Response setChatPermissions(array $data)                Use this method to set default chat permissions for all members. The bot must be an administrator in the group or a supergroup for this to work and must have the can_restrict_members admin rights. Returns True on success.
 * @method static Response exportChatInviteLink(array $data)              Use this method to generate a new invite link for a chat. Any previously generated link is revoked. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns the new invite link as String on success.
 * @method static Response createChatInviteLink(array $data)              Use this method to create an additional invite link for a chat. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. The link can be revoked using the method revokeChatInviteLink. Returns the new invite link as ChatInviteLink object.
 * @method static Response editChatInviteLink(array $data)                Use this method to edit a non-primary invite link created by the bot. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns the edited invite link as a ChatInviteLink object.
 * @method static Response revokeChatInviteLink(array $data)              Use this method to revoke an invite link created by the bot. If the primary link is revoked, a new link is automatically generated. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns the revoked invite link as ChatInviteLink object.
 * @method static Response approveChatJoinRequest(array $data)            Use this method to approve a chat join request. The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right. Returns True on success.
 * @method static Response declineChatJoinRequest(array $data)            Use this method to decline a chat join request. The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right. Returns True on success.
 * @method static Response setChatPhoto(array $data)                      Use this method to set a new profile photo for the chat. Photos can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
 * @method static Response deleteChatPhoto(array $data)                   Use this method to delete a chat photo. Photos can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
 * @method static Response setChatTitle(array $data)                      Use this method to change the title of a chat. Titles can't be changed for private chats. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
 * @method static Response setChatDescription(array $data)                Use this method to change the description of a group, a supergroup or a channel. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Returns True on success.
 * @method static Response pinChatMessage(array $data)                    Use this method to pin a message in a supergroup or a channel. The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’ admin right in the supergroup or ‘can_edit_messages’ admin right in the channel. Returns True on success.
 * @method static Response unpinChatMessage(array $data)                  Use this method to unpin a message in a supergroup or a channel. The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’ admin right in the supergroup or ‘can_edit_messages’ admin right in the channel. Returns True on success.
 * @method static Response unpinAllChatMessages(array $data)              Use this method to clear the list of pinned messages in a chat. If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' admin right in a supergroup or 'can_edit_messages' admin right in a channel. Returns True on success.
 * @method static Response leaveChat(array $data)                         Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
 * @method static Response getChat(array $data)                           Use this method to get up to date information about the chat (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.). Returns a Chat object on success.
 * @method static Response getChatAdministrators(array $data)             Use this method to get a list of administrators in a chat. On success, returns an Array of ChatMember objects that contains information about all chat administrators except other bots. If the chat is a group or a supergroup and no administrators were appointed, only the creator will be returned.
 * @method static Response getChatMemberCount(array $data)                Use this method to get the number of members in a chat. Returns Int on success.
 * @method static Response getChatMember(array $data)                     Use this method to get information about a member of a chat. Returns a ChatMember object on success.
 * @method static Response setChatStickerSet(array $data)                 Use this method to set a new group sticker set for a supergroup. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method. Returns True on success.
 * @method static Response deleteChatStickerSet(array $data)              Use this method to delete a group sticker set from a supergroup. The bot must be an administrator in the chat for this to work and must have the appropriate admin rights. Use the field can_set_sticker_set optionally returned in getChat requests to check if the bot can use this method. Returns True on success.
 * @method static Response answerCallbackQuery(array $data)               Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.
 * @method static Response setMyCommands(array $data)                     Use this method to change the list of the bot's commands. Returns True on success.
 * @method static Response deleteMyCommands(array $data)                  Use this method to delete the list of the bot's commands for the given scope and user language. After deletion, higher level commands will be shown to affected users. Returns True on success.
 * @method static Response getMyCommands()                                Use this method to get the current list of the bot's commands. Requires no parameters. Returns Array of BotCommand on success.
 * @method static Response setChatMenuButton()                            Use this method to change the bot's menu button in a private chat, or the default menu button. Returns True on success.
 * @method static Response getChatMenuButton()                            Use this method to get the current value of the bot's menu button in a private chat, or the default menu button. Returns MenuButton on success.
 * @method static Response setMyDefaultAdministratorRights()              Use this method to change the default administrator rights requested by the bot when it's added as an administrator to groups or channels. These rights will be suggested to users, but they are are free to modify the list before adding the bot. Returns True on success.
 * @method static Response getMyDefaultAdministratorRights()              Use this method to get the current default administrator rights of the bot. Returns ChatAdministratorRights on success.
 *
 *
 * Updating messages
 * The following methods allow you to change an existing message in the message history instead of sending a new one with a result of an action. This is most useful for messages with inline keyboards using callback queries, but can also help reduce clutter in conversations with regular chat bots.
 *
 * @method static Response editMessageText(array $data)          Use this method to edit text and game messages sent by the bot or via the bot (for inline bots). On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
 * @method static Response editMessageCaption(array $data)       Use this method to edit captions of messages sent by the bot or via the bot (for inline bots). On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
 * @method static Response editMessageMedia(array $data)         Use this method to edit audio, document, photo, or video messages. On success, if the edited message was sent by the bot, the edited Message is returned, otherwise True is returned.
 * @method static Response editMessageReplyMarkup(array $data)   Use this method to edit only the reply markup of messages sent by the bot or via the bot (for inline bots). On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
 * @method static Response stopPoll(array $data)                 Use this method to stop a poll which was sent by the bot. On success, the stopped Poll with the final results is returned.
 * @method static Response deleteMessage(array $data)            Use this method to delete a message, including service messages, with certain limitations. Returns True on success.
 *
 *
 * Stickers
 * The following methods and objects allow your bot to handle stickers and sticker sets.
 *
 * @method static Response sendSticker(array $data)               Use this method to send static .WEBP, animated .TGS, or video .WEBM stickers. On success, the sent Message is returned.
 * @method static Response getStickerSet(array $data)             Use this method to get a sticker set. On success, a StickerSet object is returned.
 * @method static Response uploadStickerFile(array $data)         Use this method to upload a .png file with a sticker for later use in createNewStickerSet and addStickerToSet methods (can be used multiple times). Returns the uploaded File on success.
 * @method static Response createNewStickerSet(array $data)       Use this method to create new sticker set owned by a user. The bot will be able to edit the created sticker set. Returns True on success.
 * @method static Response addStickerToSet(array $data)           Use this method to add a new sticker to a set created by the bot. Returns True on success.
 * @method static Response setStickerPositionInSet(array $data)   Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
 * @method static Response deleteStickerFromSet(array $data)      Use this method to delete a sticker from a set created by the bot. Returns True on success.
 * @method static Response setStickerSetThumb(array $data)        Use this method to set the thumbnail of a sticker set. Animated thumbnails can be set for animated sticker sets only. Returns True on success.
 *
 *
 * Inline mode
 * The following methods and objects allow your bot to work in inline mode.
 *
 * @method static Response answerInlineQuery(array $data)   Use this method to send answers to an inline query. On success, True is returned.
 * @method static Response answerWebAppQuery(array $data)   Use this method to set the result of an interaction with a Web App and send a corresponding message on behalf of the user to the chat from which the query originated. On success, a SentWebAppMessage object is returned.
 * @method static Response SentWebAppMessage(array $data)   Contains information about an inline message sent by a Web App on behalf of a user.
 *
 *
 * Payments
 * Your bot can accept payments from Telegram users. Please see the introduction to payments for more details on the process and how to set up payments for your bot.
 *
 * @method static Response sendInvoice(array $data)              Use this method to send invoices. On success, the sent Message is returned.
 * @method static Response answerShippingQuery(array $data)      If you sent an invoice requesting a shipping address and the parameter is_flexible was specified, the Bot API will send an Update with a shipping_query field to the bot. Use this method to reply to shipping queries. On success, True is returned.
 * @method static Response answerPreCheckoutQuery(array $data)   Once the user has confirmed their payment and shipping details, the Bot API sends the final confirmation in the form of an Update with the field pre_checkout_query. Use this method to respond to such pre-checkout queries. On success, True is returned.
 *
 *
 * Telegram Passport
 * Telegram Passport is a unified authorization method for services that require personal identification. Users can upload their documents once, then instantly share their data with services that require real-world ID (finance, ICOs, etc.).
 *
 * @method static Response setPassportDataErrors(array $data)   Informs a user that some of the Telegram Passport elements they provided contains errors. The user will not be able to re-submit their Passport to you until the errors are fixed (the contents of the field for which you returned the error must change). Returns True on success. Use this if the data submitted by the user doesn't satisfy the standards your service requires for any reason. For example, if a birthday date seems invalid, a submitted document is blurry, a scan shows evidence of tampering, etc. Supply some details in the error message to make sure the user knows how to correct the issues.
 *
 *
 * Games
 * our bot can offer users HTML5 games to play solo or to compete against each other in groups and one-on-one chats. Create games via @BotFather using the /newgame command. Please note that this kind of power requires responsibility: you will need to accept the terms for each game that your bots will be offering.
 *
 * @method static Response sendGame(array $data)            our bot can offer users HTML5 games to play solo or to compete against each other in groups and one-on-one chats. Create games via @BotFather using the /newgame command. Please note that this kind of power requires responsibility: you will need to accept the terms for each game that your bots will be offering.
 * @method static Response setGameScore(array $data)        Use this method to set the score of the specified user in a game. On success, if the message was sent by the bot, returns the edited Message, otherwise returns True. Returns an error, if the new score is not greater than the user's current score in the chat and force is False.
 * @method static Response getGameHighScores(array $data)   Use this method to get data for high score tables. Will return the score of the specified user and several of his neighbors in a game. On success, returns an Array of GameHighScore objects.
 */
class Request
{

    /**
     * Available fields for InputFile helper
     *
     * This is basically the list of all fields that allow InputFile objects
     * for which input can be simplified by providing local path directly  as string.
     *
     * @var array
     */
    private static array $input_file_fields = [
        'setWebhook' => ['certificate'],
        'sendPhoto' => ['photo'],
        'sendAudio' => ['audio', 'thumb'],
        'sendDocument' => ['document', 'thumb'],
        'sendVideo' => ['video', 'thumb'],
        'sendAnimation' => ['animation', 'thumb'],
        'sendVoice' => ['voice', 'thumb'],
        'sendVideoNote' => ['video_note', 'thumb'],
        'setChatPhoto' => ['photo'],
        'sendSticker' => ['sticker'],
        'uploadStickerFile' => ['png_sticker'],
        'createNewStickerSet' => ['png_sticker', 'tgs_sticker', 'webm_sticker'],
        'addStickerToSet' => ['png_sticker', 'tgs_sticker', 'webm_sticker'],
        'setStickerSetThumb' => ['thumb'],
    ];

    /**
     * URI of the Telegram API
     *
     * @var string
     */
    private static string $api_base_uri = 'https://api.telegram.org';

    /**
     * URI of the Telegram API for downloading files (relative to $api_base_url or absolute)
     *
     * @var string
     */
    private static string $api_base_download_uri = '/file/bot{API_KEY}';

    /**
     * The current action that is being executed
     *
     * @var string
     */
    private static string $current_action = '';

    /**
     * The temporary token used for the current action
     *
     * @var string
     */
    private static string $current_token = '';

    /**
     * Use this method to get stats of given user in a supergroup or channel.
     *
     * @param int $user_id User identifier
     * @param int $chat_id Identifier of the chat to get stats for
     *
     * @return string {left, member, administrator, creator}
     */
    public static function getChatMemberStatus(int $user_id, int $chat_id): string
    {
        $response = self::getChatMember([
            'user_id' => $user_id,
            'chat_id' => $chat_id,
        ]);

        return $response->getResult()->status ?? "left";
    }

    /**
     * Any statically called method should be relayed to the `send` method.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return Response
     * @throws TelegramException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (isset($arguments[1])) {
            self::$current_token = $arguments[1];
        }

        return static::send($name, reset($arguments) ?: []);
    }

    /**
     * Send command
     *
     * @param string $action
     * @param array $data
     *
     * @return Response
     * @throws TelegramException
     */
    public static function send(string $action, array $data = []): Response
    {
        self::$current_action = $action;

        $raw_response = self::execute($action, $data);

        if (!Toolkit::isJson($raw_response)) {
            TelegramLog::error($raw_response);
            throw new TelegramException('Invalid response from API');
        }

        $response = new Response(json_decode($raw_response, true));

        if (!$response->isOk() && $response->getErrorCode() === 401 && $response->getDescription() === 'Unauthorized') {
            throw new InvalidBotTokenException();
        }

        self::$current_action = '';
        static::$current_token = '';

        return $response;
    }

    /**
     * Execute HTTP Request
     *
     * @param string $action Action to execute
     * @param array $data Data to attach to the execution
     *
     * @return string Result of the HTTP Request
     */
    private static function execute(string $action, array $data): string
    {
        $request = self::create($action, $data);

        $response = self::getClient()->get($request['url'], $request['options']);

        return $response->getBody();
    }

    /**
     * Create a Http Request
     *
     * @param string $action Action to execute
     * @param array $data Data to attach to the execution
     *
     * @return array An array of the setUpRequestParams and the url
     */
    public static function create(string $action, array $data): array
    {
        if (isset($data['bot_token'])) {
            self::$current_token = $data['bot_token'];
        }

        return [
            'url' => self::getApiPath() . $action,
            'options' => self::setUpRequestParams($data)
        ];
    }

    /**
     * Get the Telegram API path
     *
     * @return string
     */
    public static function getApiPath(): string
    {
        if (static::$current_token !== '') {
            return self::$api_base_uri . '/bot' . static::$current_token . '/';
        }

        return self::$api_base_uri . '/bot' . Telegram::getApiToken() . '/';
    }

    /**
     * Properly set up the request params
     *
     * If any item of the array is a resource, reformat it to a multipart request.
     * Else, just return the passed data as form params.
     *
     * @param array $data
     * @return array
     */
    private static function setUpRequestParams(array $data): array
    {
        $multipart = [];
        $has_resource = false;

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'TelegramBot-PHP/' . Telegram::$VERSION
            ]
        ];

        foreach ($data as $key => &$item) {
            if (array_key_exists(self::$current_action, self::$input_file_fields) && in_array($key, self::$input_file_fields[self::$current_action], true)) {

                if (is_string($item) && file_exists($item)) {
                    $has_resource = true;

                } elseif (filter_var($item, FILTER_VALIDATE_URL)) {
                    $has_resource = false;
                    continue;

                } else {
                    throw new TelegramException(
                        'Invalid file path or URL: ' . $item . ' for ' . self::$current_action . ' action'
                    );
                }

                $multipart[$key] = $item;
                continue;
            }

            if ($item instanceof Entity) {
                $item = $item->getRawData();
            }

            if (is_array($item)) {
                $item = json_encode($item);
            }

            $options['query'][$key] = $item;
        }
        unset($item);

        if ($has_resource) {
            $options['multipart'] = FormData::create($multipart);
        }

        return $options;
    }

    /**
     * Initialize a http client
     *
     * @return Client
     */
    private static function getClient(): Client
    {
        return new Client();
    }

}
