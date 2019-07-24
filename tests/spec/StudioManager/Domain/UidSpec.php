<?php

namespace spec\StudioManager\Domain;

use StudioManager\Domain\Exception\UidException;
use PhpSpec\ObjectBehavior;

class UidSpec extends ObjectBehavior
{
    function it_returns_given_uid_as_string()
    {
        $uid = 'c78f6099af8d599dea2ce2a40894c4c5';
        $this->beConstructedWith($uid);

        $this->__toString()->shouldBe($uid);
    }

    function it_throws_exception_when_given_uid_is_too_short()
    {
        $tooShortUid = '78f6099af8d599dea2ce2a40894c4c5';
        $this->beConstructedWith($tooShortUid);
        $this->shouldThrow(UidException::class)->duringInstantiation();
    }

    function it_throws_exception_when_given_uid_is_too_long()
    {
        $tooLongUid = 'c78f6099af8d599dea2ce2a40894c4c5XXX';
        $this->beConstructedWith($tooLongUid);
        $this->shouldThrow(UidException::class)->duringInstantiation();
    }

    function it_throws_exception_when_given_uid_contains_unexpected_character()
    {
        $uidWithUnexpectedCharacter = 'G78f6099af8d599dea2ce2a40894c4c5XXX';
        $this->beConstructedWith($uidWithUnexpectedCharacter);
        $this->shouldThrow(UidException::class)->duringInstantiation();
    }

    function it_generates_uid_when_is_not_given()
    {
        $this->beConstructedWith(null);
        $this->__toString()->shouldMatch('/[a-f0-9]{32}/');
    }
}
