# Author Info
Author Info provides additional information about the author of a Channel entry.
It is intended for use within a standard `{exp:channel:entries}` tag, or
equivalent.

## Example Usage

    {exp:channel:entries channel='example'}
      {exp:author_info entry_id='{entry_id}'}
      {if no_results}<p>Unable to find the author info.</p>{/if}

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
