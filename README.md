## An Important Note About Support

Author Info (in common with all of my ExpressionEngine add-ons) is no longer officially supported.

The source code is reasonably well-documented, and you are free to fork the repo if you'd like to make some changes or improvements (it's distributed under a liberal open source license).

Hopefully this will be everything you need to use this add-on in your projects, but if not please don't email me asking for support; I don't even have ExpressionEngine installed locally any more.

## Overview

Author Info provides additional information about the author of a Channel entry. It is intended for use within a standard `{exp:channel:entries}` tag, or equivalent.

## Example Usage

    {exp:channel:entries channel='example'}
      {exp:author_info entry_id='{entry_id}'}

      <dl>
        <dt>Author Email</dt>
        <dd>{author:email}</dd>

        <dt>Author Group ID</dt>
        <dd>{author:group_id}</dd>

        <dt>Author Is Admin?</dt>
        <dd>{if author:is_admin}Big Cheese{if:else}Little Minion{/if}</dd>

        <dt>Author Member ID</dt>
        <dd>{author:member_id}</dd>

        <dt>Author Screen Name</dt>
        <dd>{author:screen_name}</dd>

        <dt>Author Username</dt>
        <dd>{author:username}</dd>
      </dl>
      {/exp:author_info}
    {/exp:channel:entries}

## Parameters
The Author Info tag accepts a single mandatory parameter, `entry_id`.

## Single Variables
The following single variables are available for use within the Author Info tag
pair.

`author:email`
: The Member's email address.

`author:group_id`
: The Member's Member Group ID.

`author:is_admin`
: `TRUE` if the Member has Control Panel access, `FALSE` otherwise.

`author:member_id`
: The Member's ID.

`author:screen_name`
: The Member's Screen Name.

`author:username`
: The Member's Username.
