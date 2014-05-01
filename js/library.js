function charValid(c)
{
    return ((c >= '0') && (c <= '9')) || ((c >= 'a') && (c <= 'z')) || ((c >= 'A') && (c <= 'Z'));
}

function strValid(s)
{
    if (s == "")
    {
        return false;
    }
    for (var i = 0; i < s.length; ++i)
    {
        if (!charValid(s[i]))
        {
            return false;
        }
    }
    return true;
}