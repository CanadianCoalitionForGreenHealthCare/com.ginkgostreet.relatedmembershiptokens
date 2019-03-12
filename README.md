# Related Membership Tokens

In the case of conferred memberships (i.e. memberships bestowed on a contact "by relationship"), CiviCRM's Scheduled Reminders feature sends an email to all of the contacts associated with that membership: the primary contact as well as all the contacts with a "by relationship" membership. When standard email tokens are used in this instance, the tokens are populated based on the contact the email is being sent to, not the contact who holds the "primary" membership. 

If we want to include language in the membership reminder that refers to the contact with the primary membership, we have no way of effectively doing that. And example might be:

> "Hi *Mary*, the *Business Membership* for *Plants United, Inc.* will expire on May 31, 2019."

Note that the tokens for Mary would be `contact.first_name` and that the expiry date _could_ be from her own (non-primary) membership, but the inclusion of the organization name isn't possible. While we could work around this using vague language, it would be much better if we had tokens that populated based on the Primary Membership Contact Record. Another use case might be if the NPO who Mary's business is a member of wished to send her a reminder email that looked like an "invoice" with additional information about the business: address, phone, etc. If Mary's personal contact record is the same as her business, this isn't an issue. But this isn't something we can count on.

## New Primary Membership tokens

This extension implements the following tokens that are populated by the contact record of the primary membership, to address the use cases described above:

- *Primary Membership: Membership ID:* {primarymembership.id}
- *Primary Membership: Contact ID:* {primarymembership.contact_id}
- *Primary Membership: Contact Display Name:* {primarymembership.contact_display_name}
- *Primary Membership: Contact Address Block:* {primarymembership.contact_address_block}
- *Primary Membership: Contact Phone (primary):* {primarymembership.contact_phone}
- *Primary Membership: Contact Email Address (primary):* {primarymembership.contact_email}

## Non-critical Primary Membership data that was not included as tokens in this extension

We feel these tokens are somewhat unnecessary as this information is conferred to the "by relationship" membership. These were not included in the extension, and are documented here for posterity and whatnot.

- *Primary Membership: Join Date:* {primarymembership.join_date}
- *Primary Membership: Start Date:* {primarymembership.start_date}
- *Primary Membership: Status:* {primarymembership.status}
- *Primary Membership: Type:* {primarymembership.type}
- *Primary Membership: End Date:* {primarymembership.end_date}
- *Primary Membership: Fee:* {primarymembership.fee}
