<?php

namespace Exbil\LexOffice\Contact;

use Exbil\LexOffice\PaginationClient;

class Contact extends PaginationClient
{
    protected string $resource = 'contacts';

    public string $sortDirection = 'ASC';

    public string $sortProperty = 'name';

    /**
     * @param int $page
     * @return string
     */
    public function generateUrl(int $page): string
    {
        return parent::generateUrl($page) .
            '&direction=' . $this->sortDirection .
            '&property=' .$this->sortProperty;
    }
}
