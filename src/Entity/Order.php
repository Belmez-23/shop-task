<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $paidAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $refundedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, OrderGoodsList>
     */
    #[ORM\OneToMany(targetEntity: OrderGoodsList::class, mappedBy: 'order', orphanRemoval: true)]
    private Collection $goodsList;

    public function __construct()
    {
        $this->goodsList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Good>
     */
    public function getGoods(): Collection
    {
        return $this->goods;
    }

    public function addGood(Good $good): static
    {
        if (!$this->goods->contains($good)) {
            $this->goods->add($good);
            $good->setOneToOne($this);
        }

        return $this;
    }

    public function removeGood(Good $good): static
    {
        if ($this->goods->removeElement($good)) {
            // set the owning side to null (unless already changed)
            if ($good->getOneToOne() === $this) {
                $good->setOneToOne(null);
            }
        }

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(?\DateTimeImmutable $paidAt): static
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getRefundedAt(): ?\DateTimeImmutable
    {
        return $this->refundedAt;
    }

    public function setRefundedAt(?\DateTimeImmutable $refundedAt): static
    {
        $this->refundedAt = $refundedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderGoodsList>
     */
    public function getGoodsList(): Collection
    {
        return $this->goodsList;
    }

    public function addGoodsList(OrderGoodsList $goodsList): static
    {
        if (!$this->goodsList->contains($goodsList)) {
            $this->goodsList->add($goodsList);
            $goodsList->setOrder($this);
        }

        return $this;
    }

    public function removeGoodsList(OrderGoodsList $goodsList): static
    {
        if ($this->goodsList->removeElement($goodsList)) {
            // set the owning side to null (unless already changed)
            if ($goodsList->getOrder() === $this) {
                $goodsList->setOrder(null);
            }
        }

        return $this;
    }
}
