<?php

require_once 'InterfaceFoo.php';

class Bar implements Foo {

	#[\Override]
	public function echo(string $world): int {
		return 20;
	}
}