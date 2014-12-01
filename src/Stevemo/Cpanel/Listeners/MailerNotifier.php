<?php namespace Stevemo\Cpanel\Listeners;

use Illuminate\Mail\Mailer;
use Illuminate\Translation\Translator;

class MailerNotifier {

	/**
	 * @type \Illuminate\Mail\Mailer
	 */
	private $mailer;

	/**
	 * @type \Illuminate\Translation\Translator
	 */
	private $translator;

	/**
	 * @param \Illuminate\Mail\Mailer            $mailer
	 * @param \Illuminate\Translation\Translator $translator
	 */
	function __construct(Mailer $mailer, Translator $translator)
	{
		$this->mailer = $mailer;
		$this->translator = $translator;
	}

	/**
	 *
	 *
	 * @author Steve Montambeault
	 *
	 * @param $member
	 */
	public function whenMemberHasRegistered($member)
	{
		$subject = $this->translator->get('cpanel::registration.email.subject');

		$this->mailer->queue('cpanel::emails.activation', $member, function($message) use ($member, $subject)
		{
			$message->to($member['email'], $member['fullname'])->subject($subject);
		});
	}

} 