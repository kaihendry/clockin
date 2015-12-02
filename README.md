# Clock in, Clock out

This a minimalistic implementation ~200 LOC of a [time
clock](https://en.wikipedia.org/wiki/Time_clock) as described in my
[blog](http://natalian.org/2015/11/29/Neighbourhood_watch_on_the_Web/).

# Review

I would appreciate a review since this is my first foray into the world of Web
sessions and a time/attendance system.

I decided upon PHP `$_SESSION` since that might be the most mature and easy to
implement.

I was naively hoping that PHP's `$_SESSION` would manage the entire record, but
as I began to understand it, I now view it as a very simple UX tool to ensure
the user doesn't inadvertently re-login from "/". That's it!

# Questions / Things I don't understand how to handle

If a user is already logged in another device. What happens to the session? Can
they be combined? Can the first session prevent a new session with the same
credentials from being created?

Can the session be used to "clock out" the user after say a **time out**?

# Assumptions

That the **identity number is secret**. I know I display on the index page, but
this is for debugging. I wanted to avoid passwords for this prototype. In
future I will make the "clock out" action that's not done by a user, a
privileged protected action.
