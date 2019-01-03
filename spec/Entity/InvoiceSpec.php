<?php

declare(strict_types=1);

namespace spec\Sylius\InvoicingPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\InvoicingPlugin\Entity\BillingDataInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceChannel;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Sylius\InvoicingPlugin\Entity\LineItemInterface;
use Sylius\InvoicingPlugin\Entity\ShopBillingData;
use Sylius\InvoicingPlugin\Entity\TaxItemInterface;

final class InvoiceSpec extends ObjectBehavior
{
    function let(
        BillingDataInterface $billingData,
        LineItemInterface $lineItem,
        TaxItemInterface $taxItem
    ): void {
        $issuedAt = new \DateTimeImmutable('now');

        $shopBillingData = new ShopBillingData();
        $shopBillingData->setTaxId('11111');
        $shopBillingData->setCountryCode('US');
        $shopBillingData->setStreet('sample_street');
        $shopBillingData->setPostcode('11-111');
        $shopBillingData->setCompany('sample_company');
        $shopBillingData->setCity('sample_city');

        $this->beConstructedWith(
            '7903c83a-4c5e-4bcf-81d8-9dc304c6a353',
            $issuedAt->format('Y/m') . '/000000001',
            '007',
            $issuedAt,
            $billingData,
            'USD',
            'en_US',
            10300,
            new ArrayCollection([$lineItem->getWrappedObject()]),
            new ArrayCollection([$taxItem->getWrappedObject()]),
            new InvoiceChannel('WEB-US', 'United States'),
            $shopBillingData
        );
    }

    function it_implements_invoice_interface(): void
    {
        $this->shouldImplement(InvoiceInterface::class);
    }

    function it_implements_resource_interface(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_has_an_id(
        BillingDataInterface $billingData,
        LineItemInterface $lineItem,
        TaxItemInterface $taxItem
    ): void {
        $issuedAt = new \DateTimeImmutable('now');
        $lineItems = new ArrayCollection([$lineItem->getWrappedObject()]);
        $taxItems = new ArrayCollection([$taxItem->getWrappedObject()]);
        $invoiceChannel = new InvoiceChannel('WEB-US', 'United States');

        $shopBillingData = new ShopBillingData();
        $shopBillingData->setTaxId('11111');
        $shopBillingData->setCountryCode('US');
        $shopBillingData->setStreet('sample_street');
        $shopBillingData->setPostcode('11-111');
        $shopBillingData->setCompany('sample_company');
        $shopBillingData->setCity('sample_city');

        $this->beConstructedWith(
            '7903c83a-4c5e-4bcf-81d8-9dc304c6a353',
            $issuedAt->format('Y/m') . '/000000001',
            '007',
            $issuedAt,
            $billingData,
            'USD',
            'en_US',
            10300,
            $lineItems,
            $taxItems,
            $invoiceChannel,
            $shopBillingData
        );

        $this->id()->shouldReturn('7903c83a-4c5e-4bcf-81d8-9dc304c6a353');
        $this->number()->shouldReturn($issuedAt->format('Y/m') . '/000000001');
        $this->orderNumber()->shouldReturn('007');
        $this->billingData()->shouldReturn($billingData);
        $this->currencyCode()->shouldReturn('USD');
        $this->localeCode()->shouldReturn('en_US');
        $this->total()->shouldReturn(10300);
        $this->lineItems()->shouldReturn($lineItems);
        $this->taxItems()->shouldReturn($taxItems);
        $this->channel()->shouldReturn($invoiceChannel);
        $this->shopBillingData()->shouldReturn($shopBillingData);
    }
}
